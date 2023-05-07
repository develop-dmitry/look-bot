<?php

declare(strict_types=1);

namespace Look\Infrastructure\Messenger\TelegramMessenger;

use Look\Application\Client\IdentifyClient\Interface\IdentifyClientInterface;
use Look\Application\Dictionary\DictionaryInterface;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerContainerInterface;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerInterface;
use Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface\FindMessengerUserInterface;
use Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface\SaveMessengerUserInterface;
use Look\Application\Messenger\MessengerUser\SaveMessengerUser\SaveMessengerUserRequest;
use Look\Domain\GeoLocation\Interface\GeoLocationBuilderInterface;
use Psr\Log\LoggerInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use Throwable;

class TelegramMessenger implements MessengerInterface
{
    /**
     * Initialized inside handler
     */
    protected TelegramMessengerContext $context;

    protected TelegramMessengerHandlerManager $handlerManager;
    protected TelegramMessengerVisual $visual;

    public function __construct(
        protected Nutgram $bot,
        protected SaveMessengerUserInterface $saveMessengerUser,
        protected LoggerInterface $logger,
        protected DictionaryInterface $dictionary,
        GeoLocationBuilderInterface $geoLocationBuilder,
        IdentifyClientInterface $identifyClient,
        FindMessengerUserInterface $findMessengerUser
    ) {
        $this->visual = new TelegramMessengerVisual($this->bot, $this->logger);

        $this->context = new TelegramMessengerContext(
            $identifyClient,
            $findMessengerUser,
            $this->bot,
            $geoLocationBuilder,
            $this->logger
        );

        $this->handlerManager = new TelegramMessengerHandlerManager(
            $this->context,
            $this->bot,
            $this->logger
        );
    }

    public function run(): void
    {
        $this->bot->setRunningMode(Webhook::class);

        $this->handlerManager->init([$this, 'executeHandler']);

        $this->bot->run();
    }

    public function setHandlerContainer(MessengerHandlerContainerInterface $handlers): void
    {
        $this->handlerManager->setHandlers($handlers);
    }

    public function executeHandler(
        ?MessengerHandlerInterface $handler, MessengerHandlerType $type
    ): bool|array|Message|null {
        $this->context->init();

        if ($handler) {
            try {
                if ($type === MessengerHandlerType::Message && $this->context->isIdentifiedMessengerUser()) {
                    $this->context->getMessengerUser()?->setMessageHandler(null);
                }

                $handler->handle($this->context, $this->visual);

                $this->saveMessengerUser();
            } catch (Throwable $exception) {
                $this->visual->sendMessage($this->dictionary->getTranslate('telegram.network_error'));

                $this->logger->emergency('Непредвиденная ошибка', [
                    'exception' => $exception,
                    'context' => (array) $this->context
                ]);
            }
        } else {
            $this->visual->sendMessage($this->dictionary->getTranslate('telegram.unknown_handler'));
        }

        return $this->visual->makeMessage();
    }

    protected function saveMessengerUser(): void
    {
        if (!$this->context->isIdentifiedMessengerUser()) {
            return;
        }

        $messengerUser = $this->context->getMessengerUser();

        $request = new SaveMessengerUserRequest($messengerUser);
        $this->saveMessengerUser->saveMessengerUser($request);
    }
}
