<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Look\Application\Messenger\MenuMessengerHandler;
use Look\Application\Messenger\WelcomeMessengerHandler;
use Look\Domain\Messenger\Exception\MessengerHandlerAlreadyExistsException;
use Look\Domain\Messenger\Handler\MessengerHandlerName;
use Look\Domain\Messenger\Handler\MessengerHandlerType;
use Look\Domain\Messenger\Interface\ButtonFactoryInterface;
use Look\Domain\Messenger\Interface\KeyboardFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerContainerFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerHandlerContainerInterface;
use Look\Domain\Messenger\Interface\MessengerHandlerInterface;
use Look\Domain\Messenger\Interface\MessengerInterface;
use Look\Domain\Messenger\Interface\OptionFactoryInterface;
use Psr\Log\LoggerInterface;

class TelegramController extends Controller
{
    protected MessengerHandlerContainerInterface $handlers;

    public function __construct(
        protected MessengerInterface $messenger,
        protected MessengerContainerFactoryInterface $messengerContainerFactory,
        protected LoggerInterface $logger,
        protected KeyboardFactoryInterface $keyboardFactory,
        protected ButtonFactoryInterface $buttonFactory,
        protected OptionFactoryInterface $optionFactory
    ) {
        $this->handlers = $this->messengerContainerFactory->makeHandlerContainer();
    }

    public function handle(Request $request): void
    {
        $this->logger->debug('Запрос из телеграма', $request->toArray());

        $this->initHandlers();
        $this->messenger->setHandlerContainer($this->handlers);
        $this->messenger->run();
    }

    protected function initHandlers(): void
    {
        $this->addHandler(
            MessengerHandlerName::Start,
            MessengerHandlerType::Command,
            new WelcomeMessengerHandler(
                $this->logger,
                $this->keyboardFactory,
                $this->buttonFactory,
                $this->optionFactory
            )
        );

        $this->addHandler(
            MessengerHandlerName::Menu,
            MessengerHandlerType::Command,
            new MenuMessengerHandler(
                $this->logger,
                $this->keyboardFactory,
                $this->buttonFactory,
                $this->optionFactory
            )
        );
    }

    protected function addHandler(
        MessengerHandlerName $name,
        MessengerHandlerType $type,
        MessengerHandlerInterface $handler
    ): void {
        try {
            $this->handlers->addHandler($name, $type, $handler);
        } catch (MessengerHandlerAlreadyExistsException $exception) {
            $this->logger->emergency('Дублирование обработчика', ['exception' => $exception]);
        }
    }
}
