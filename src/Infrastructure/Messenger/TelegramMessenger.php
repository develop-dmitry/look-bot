<?php

declare(strict_types=1);

namespace Look\Infrastructure\Messenger;

use Illuminate\Database\Eloquent\Casts\Json;
use Look\Application\Client\ClientUseCaseInterface;
use Look\Application\Client\Request\Interface\ClientRequestFactoryInterface;
use Look\Domain\Entity\Client\Exception\ClientNotFoundException;
use Look\Domain\Entity\Client\Interface\ClientInterface;
use Look\Domain\Entity\Exception\RepositoryException;
use Look\Domain\Entity\MessengerUser\Exception\MessengerUserNotFoundException;
use Look\Domain\Entity\MessengerUser\Interface\TelegramMessengerUserRepositoryInterface;
use Look\Domain\Messenger\Exception\MessengerHandlerNotFoundException;
use Look\Domain\Messenger\Exception\NextMessageHandlerNotFoundException;
use Look\Domain\Messenger\Handler\MessengerHandlerName;
use Look\Domain\Messenger\Handler\MessengerHandlerType;
use Look\Domain\Messenger\Interface\ButtonInterface;
use Look\Domain\Messenger\Interface\KeyboardInterface;
use Look\Domain\Messenger\Interface\MessengerRepositoryInterface;
use Look\Domain\Messenger\Interface\MessengerHandlerContainerInterface;
use Look\Domain\Messenger\Interface\MessengerHandlerInterface;
use Look\Domain\Messenger\Interface\MessengerInterface;
use Look\Domain\Messenger\Interface\MessengerRequestFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerRequestInterface;
use Look\Domain\Messenger\Keyboard\KeyboardType;
use Look\Domain\Messenger\Option\ButtonOption\ButtonOptionName;
use Look\Domain\Messenger\Option\KeyboardOption\KeyboardOptionName;
use Look\Domain\Value\Exception\InvalidValueException;
use Psr\Log\LoggerInterface;
use RuntimeException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use Throwable;

class TelegramMessenger implements MessengerInterface
{
    /**
     * Initialized inside handler
     */
    protected ClientInterface $client;

    protected ?MessengerHandlerContainerInterface $handlers = null;

    protected ?KeyboardInterface $keyboard = null;

    protected bool $editMessage = false;

    protected string $message = '';

    protected ?MessengerRequestInterface $request = null;

    protected ?MessengerHandlerName $nextMessageHandler = null;

    public function __construct(
        protected Nutgram                                  $bot,
        protected MessengerRequestFactoryInterface         $messengerRequestFactory,
        protected ClientUseCaseInterface                   $clientUseCase,
        protected ClientRequestFactoryInterface            $clientRequestFactory,
        protected TelegramMessengerUserRepositoryInterface $telegramMessengerUserRepository,
        protected LoggerInterface                          $logger,
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
        $this->nextMessageHandler = $handlerName;
    }

    protected function setHandlers(): void
    {
        if (!$this->handlers) {
            return;
        }

        foreach ($this->handlers->getHandlers(MessengerHandlerType::Text) as $name => $handler) {
            $this->bot->onText($name, fn () => $this->executeHandler($handler));
        }

        foreach ($this->handlers->getHandlers(MessengerHandlerType::Command) as $command => $handler) {
            $this->bot->onCommand($command, fn () => $this->executeHandler($handler));
        }

        $this->bot->onCallbackQuery(fn () => $this->executeHandler([$this, 'getCallbackQueryHandler']));

        $this->bot->onMessage(fn () => $this->executeHandler([$this, 'getMessageHandler']));
    }

    protected function executeHandler(callable|MessengerHandlerInterface $handler): bool|array|Message|null
    {
        try {
            $this->initClient();

            if (is_callable($handler)) {
                $handler = $handler();
            }

            $handler->handle($this->getRequest(), $this, $this->client);
        } catch (MessengerHandlerNotFoundException) {
            $this->sendMessage('Я не знаю такой команды :(');
        } catch (NextMessageHandlerNotFoundException) {
            $this->sendMessage('Не понимаю о чем вы :(');
        } catch (Throwable $exception) {
            $this->sendTechnicalErrorMessage();
            $this->logger->emergency('Непредвиденная ошибка', ['exception' => $exception, 'bot' => $this->bot]);
        }

        try {
            $telegramUser = $this->client->getTelegramUser()
                ?->setMessengerHandler($this->nextMessageHandler?->value);

            if ($telegramUser) {
                $this->telegramMessengerUserRepository->saveMessengerUser($telegramUser);
            }
        } catch (RepositoryException|InvalidValueException $exception) {
            $this->logger->emergency('Не удалось сохранить название обработчика для следующего сообщения', [
                'exception' => $exception
            ]);
        } catch (MessengerUserNotFoundException $exception) {
            $this->logger->emergency('Не удалось найти пользователя telegram', [
                'exception' => $exception
            ]);
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
            KeyboardType::Reply => $this->makeReplyKeyboardMarkup()
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

    /**
     * @return void
     * @throws RepositoryException|ClientNotFoundException|InvalidValueException|RuntimeException
     */
    protected function initClient(): void
    {
        $userId = $this->bot->userId();

        if (!($userId)) {
            throw new RuntimeException('В запросе не найден ID пользователя телеграма');
        }

        $request = $this->clientRequestFactory->makeClientByTelegramRequest($userId);

        $this->client = $this->clientUseCase->getClientByTelegram($request);
    }

    /**
     * @throws MessengerHandlerNotFoundException
     */
    protected function getCallbackQueryHandler(): ?MessengerHandlerInterface
    {
        $callbackQuery = $this->getRequest()->getCallbackQuery();

        if (!isset($callbackQuery['action'])) {
            $this->logger->emergency(
                'Не удалось получить action из callback query',
                ['callback_query' => $callbackQuery]
            );

            throw new MessengerHandlerNotFoundException('Не удалось получить action из callback query');
        }

        $action = MessengerHandlerName::tryFrom($callbackQuery['action']);

        if (!$action) {
            $this->logger->emergency(
                'Не удалось найти название обработчика для action из callback query',
                ['callback_query' => $callbackQuery]
            );

            throw new MessengerHandlerNotFoundException(
                'Не удалось найти название обработчика для action из callback query'
            );
        }

        return $this->getHandler($action, MessengerHandlerType::CallbackQuery);
    }

    /**
     * @throws MessengerHandlerNotFoundException|NextMessageHandlerNotFoundException
     */
    protected function getMessageHandler(): MessengerHandlerInterface
    {
        try {
            $telegramUser = $this->client->getTelegramUser();

            if (!$telegramUser) {
                throw new MessengerHandlerNotFoundException('Не найден пользователь телеграмма');
            }

            $handler = $telegramUser->getMessageHandler();

            if (!$handler) {
                throw new NextMessageHandlerNotFoundException(
                    'Название обработчика для сообщения не найдено'
                );
            }

            return $this->getHandler($handler, MessengerHandlerType::Message);
        } catch (RepositoryException|MessengerUserNotFoundException|InvalidValueException $exception) {
            throw new MessengerHandlerNotFoundException($exception->getMessage());
        }
    }

    /**
     * @throws MessengerHandlerNotFoundException
     */
    protected function getHandler(MessengerHandlerName $name, MessengerHandlerType $type): ?MessengerHandlerInterface
    {
        try {
            return $this->handlers->getHandler($name, $type);
        } catch (MessengerHandlerNotFoundException $exception) {
            $this->logger->error(
                'Не удалось найти обработчик',
                ['name' => $name, 'type' => $type, 'exception' => $exception]
            );

            throw $exception;
        }
    }
}
