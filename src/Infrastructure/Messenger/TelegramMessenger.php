<?php

declare(strict_types=1);

namespace Look\Infrastructure\Messenger;

use Illuminate\Database\Eloquent\Casts\Json;
use Look\Domain\Client\Exception\ClientNotFoundException;
use Look\Domain\Client\Exception\FailedCreateClientException;
use Look\Domain\Client\Interface\ClientBuilderInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\Client\Interface\ClientRepositoryInterface;
use Look\Domain\Messenger\Exception\FailedSetNextMessageHandlerException;
use Look\Domain\Messenger\Handler\MessengerHandlerName;
use Look\Domain\Messenger\Handler\MessengerHandlerType;
use Look\Domain\Messenger\Interface\ButtonInterface;
use Look\Domain\Messenger\Interface\KeyboardInterface;
use Look\Domain\Messenger\Interface\MessageHandlerRepositoryInterface;
use Look\Domain\Messenger\Interface\MessengerHandlerContainerInterface;
use Look\Domain\Messenger\Interface\MessengerHandlerInterface;
use Look\Domain\Messenger\Interface\MessengerInterface;
use Look\Domain\Messenger\Interface\MessengerRequestFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerRequestInterface;
use Look\Domain\Messenger\Keyboard\KeyboardType;
use Look\Domain\Messenger\Option\ButtonOption\ButtonOptionName;
use Look\Domain\Messenger\Option\KeyboardOption\KeyboardOptionName;
use Psr\Log\LoggerInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

class TelegramMessenger implements MessengerInterface
{
    protected ?MessengerHandlerContainerInterface $handlers = null;

    protected ?KeyboardInterface $keyboard = null;

    protected bool $editMessage = false;

    protected string $message = '';

    protected ?MessengerRequestInterface $request = null;

    public function __construct(
        protected Nutgram $bot,
        protected MessengerRequestFactoryInterface $messengerRequestFactory,
        protected ClientRepositoryInterface $clientRepository,
        protected ClientBuilderInterface $clientBuilder,
        protected MessageHandlerRepositoryInterface $messageHandlerRepository,
        protected LoggerInterface $logger
    ) {
    }

    public function run(): void
    {
        $this->bot->setRunningMode(Webhook::class);

        $this->setHandlers();

        $this->bot->run();
    }

    public function sendMessage(string $message, bool $editMessage = false): void
    {
        $this->message = $message;
        $this->editMessage = $editMessage;
    }

    public function sendKeyboard(KeyboardInterface $keyboard): void
    {
        $this->keyboard = $keyboard;
    }

    public function setHandlerContainer(MessengerHandlerContainerInterface $handlers): void
    {
        $this->handlers = $handlers;
    }

    public function sendTechnicalErrorMessage(): void
    {
        $this->sendMessage(__('telegram.network_error'));
    }

    public function setNextMessageHandler(MessengerHandlerName $handlerName): void
    {
        $this->messageHandlerRepository->setNextHandlerName($this->getClient(), $handlerName);
    }

    protected function setHandlers(): void
    {
        if (!$this->handlers) {
            return;
        }

        $textHandlers = $this->handlers->getHandlers(MessengerHandlerType::Text);
        $commandHandlers = $this->handlers->getHandlers(MessengerHandlerType::Command);

        foreach ($textHandlers as $name => $handler) {
            $this->bot->onText($name, fn () => $this->executeHandler($handler));
        }

        foreach ($commandHandlers as $command => $handler) {
            $this->bot->onCommand($command, fn () => $this->executeHandler($handler));
        }

        $this->bot->onCallbackQuery(function () {
            $callbackQuery = $this->getRequest()->getCallbackQuery();
            $action = MessengerHandlerName::tryFrom($callbackQuery['action'] ?? '');
            $handler = null;

            if ($action) {
                $handler = $this->handlers->getHandler($action, MessengerHandlerType::CallbackQuery);
            }

            return $this->executeHandler($handler);
        });

        $this->bot->onMessage(function () {
            try {
                $handler = $this->messageHandlerRepository->getNextHandlerName($this->getClient());
            } catch (FailedCreateClientException $exception) {
                $handler = null;
                $this->logger->emergency('Не удалось создать клиента', ['exception' => $exception]);
            }

            return $this->executeHandler($handler);
        });
    }

    protected function executeHandler(?MessengerHandlerInterface $handler): bool|array|Message|null
    {
        if ($handler) {
            try {
                $handler->handle(
                    $this->getRequest(),
                    $this,
                    $this->getClient()
                );
            } catch (FailedCreateClientException $exception) {
                $this->logger->emergency('Не удалось создать клиента', ['exception' => $exception]);
                $this->sendTechnicalErrorMessage();
            }
        } else {
            $this->sendTechnicalErrorMessage();
        }

        $options = $this->getMessageOptions();

        if ($this->editMessage) {
            return $this->bot->editMessageText($this->message, $options);
        }

        return $this->bot->sendMessage($this->message, $options);
    }

    protected function getRequest(): MessengerRequestInterface
    {
        if (is_null($this->request)) {
            $request = $this->messengerRequestFactory->makeMessengerRequest();

            $message = $this->bot->message()?->text;
            $callbackQuery = $this->bot->callbackQuery()?->data;

            $request->setMessage($message ?? '');
            $request->setCallbackQuery(($callbackQuery) ? Json::decode($callbackQuery) : []);

            $this->request = $request;
        }

        return $this->request;
    }

    /**
     * @return ClientInterface
     * @throws FailedCreateClientException
     */
    protected function getClient(): ClientInterface
    {
        $telegramId = $this->bot->user()?->id;

        try {
            return $this->clientRepository->getClientByTelegramId($telegramId);
        } catch (ClientNotFoundException) {
            $client = $this->clientBuilder
                ->setTelegramId($telegramId)
                ->makeClient();

            $this->clientRepository->createClient($client);

            return $client;
        }
    }

    protected function getMessageOptions(): array
    {
        $options = [];

        $keyboard = $this->adaptKeyboard();

        if ($keyboard) {
            $options['reply_markup'] = $keyboard;
        }

        return $options;
    }

    protected function adaptKeyboard(): ReplyKeyboardMarkup|InlineKeyboardMarkup|null
    {
        if (!$this->keyboard) {
            return null;
        }

        $type = $this->keyboard->getType();

        return match ($type) {
            KeyboardType::Inline => $this->makeInlineKeyboardMarkup(),
            KeyboardType::Reply => $this->makeReplyKeyboardMarkup(),
            default => null
        };
    }

    protected function makeInlineKeyboardMarkup(): InlineKeyboardMarkup
    {
        $keyboard = new InlineKeyboardMarkup();

        foreach ($this->keyboard->getRows() as $row) {
            $buttons = [];

            foreach ($row as $button) {
                $buttons[] = $this->makeInlineKeyboardButton($button);
            }

            $keyboard->addRow(...$buttons);
        }

        return $keyboard;
    }

    protected function makeReplyKeyboardMarkup(): ReplyKeyboardMarkup
    {
        $keyboard = new ReplyKeyboardMarkup(
            $this->keyboard->getOption(KeyboardOptionName::ResizeKeyboard->value)->getValue(),
            $this->keyboard->getOption(KeyboardOptionName::OneTimeKeyboard->value)->getValue(),
            $this->keyboard->getOption(KeyboardOptionName::InputFieldPlaceholder->value)->getValue(),
            $this->keyboard->getOption(KeyboardOptionName::Selective->value)->getValue(),
            $this->keyboard->getOption(KeyboardOptionName::IsPersistent->value)->getValue(),
        );

        foreach ($this->keyboard->getRows() as $row) {
            $buttons = [];

            foreach ($row as $button) {
                $buttons[] = $this->makeKeyboardButton($button);
            }

            $keyboard->addRow(...$buttons);
        }

        return $keyboard;
    }

    protected function makeInlineKeyboardButton(ButtonInterface $button): InlineKeyboardButton
    {
        return new InlineKeyboardButton(
            $button->getText(),
            $button->getOption(ButtonOptionName::Url->value)->getValue(),
            $button->getOption(ButtonOptionName::LoginUrl->value)->getValue(),
            $button->getOption(ButtonOptionName::CallbackData->value)->getValue(),
            $button->getOption(ButtonOptionName::SwitchInlineQuery->value)->getValue(),
            $button->getOption(ButtonOptionName::SwitchInlineQueryCurrentChat->value)->getValue(),
            $button->getOption(ButtonOptionName::CallbackGame->value)->getValue(),
            $button->getOption(ButtonOptionName::Pay->value)->getValue(),
            $button->getOption(ButtonOptionName::WebApp->value)->getValue()
        );
    }

    protected function makeKeyboardButton(ButtonInterface $button): KeyboardButton
    {
        return new KeyboardButton(
            $button->getText(),
            $button->getOption(ButtonOptionName::RequestContact->value)->getValue(),
            $button->getOption(ButtonOptionName::RequestLocation->value)->getValue(),
            $button->getOption(ButtonOptionName::RequestPoll->value)->getValue(),
            $button->getOption(ButtonOptionName::WebApp->value)->getValue(),
            $button->getOption(ButtonOptionName::RequestUser->value)->getValue(),
            $button->getOption(ButtonOptionName::RequestChat->value)->getValue()
        );
    }
}
