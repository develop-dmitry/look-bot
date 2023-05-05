<?php

declare(strict_types=1);

namespace Look\Infrastructure\Messenger\TelegramMessenger;

use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Exception\MessengerHandlerNotFoundException;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerContainerInterface;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Psr\Log\LoggerInterface;
use SergiX44\Nutgram\Nutgram;

class TelegramMessengerHandlerManager
{
    protected ?MessengerHandlerContainerInterface $handlers = null;

    public function __construct(
        protected TelegramMessengerContext $context,
        protected Nutgram $bot,
        protected LoggerInterface $logger
    ) {
    }

    public function init(callable $executeHandler): void
    {
        if (!$this->handlers) {
            return;
        }

        foreach ($this->handlers->getHandlers(MessengerHandlerType::Text) as $name => $handler) {
            $this->bot->onText($name, fn () => $executeHandler($handler, MessengerHandlerType::Text));
        }

        foreach ($this->handlers->getHandlers(MessengerHandlerType::Command) as $command => $handler) {
            $this->bot->onCommand($command, fn () => $executeHandler($handler, MessengerHandlerType::Command));
        }

        $this->bot->onCallbackQuery(fn () => $executeHandler(
            $this->findHandler([$this, 'getCallbackQueryHandler']),
            MessengerHandlerType::CallbackQuery)
        );

        $this->bot->onMessage(fn () => $executeHandler(
            $this->findHandler([$this, 'getMessageHandler']),
            MessengerHandlerType::Message)
        );
    }

    public function setHandlers(MessengerHandlerContainerInterface $handlers): void
    {
        $this->handlers = $handlers;
    }

    protected function findHandler(callable $finder): ?MessengerHandlerInterface
    {
        $this->context->init();

        try {
            return $finder();
        } catch (MessengerHandlerNotFoundException $exception) {
            $this->logger->emergency('Не удалось найти обработчик', [
                'exception' => $exception,
                'context' => $this->context
            ]);
        }

        return null;
    }

    /**
     * @throws MessengerHandlerNotFoundException
     */
    protected function getCallbackQueryHandler(): ?MessengerHandlerInterface
    {
        $callbackQuery = $this->context->getRequest()->getCallbackQuery();

        if (!isset($callbackQuery['action'])) {
            throw new MessengerHandlerNotFoundException('Не удалось получить action из callback query');
        }

        $action = MessengerHandlerName::tryFrom($callbackQuery['action']);

        if (!$action) {
            throw new MessengerHandlerNotFoundException(
                'Не удалось найти название обработчика для action из callback query'
            );
        }

        return $this->getHandler($action, MessengerHandlerType::CallbackQuery);
    }

    /**
     * @throws MessengerHandlerNotFoundException
     */
    protected function getMessageHandler(): MessengerHandlerInterface
    {
        if (!$this->context->isIdentifiedMessengerUser()) {
            throw new MessengerHandlerNotFoundException('Пользователь не идентифицирован');
        }

        $handler = $this->context->getMessengerUser()?->getMessageHandler();

        if (!$handler) {
            throw new MessengerHandlerNotFoundException(
                'У пользователя отсутствует остановленный обработчик для сообщения'
            );
        }

        return $this->getHandler($handler, MessengerHandlerType::Message);
    }

    /**
     * @throws MessengerHandlerNotFoundException
     */
    protected function getHandler(MessengerHandlerName $name, MessengerHandlerType $type): ?MessengerHandlerInterface
    {
        return $this->handlers->getHandler($name, $type);
    }
}
