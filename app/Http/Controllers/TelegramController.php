<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerContainer\Interface\MessengerContainerFactoryInterface;
use Look\Application\Messenger\MessengerHandler\AddSupportMessengerHandler;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Exception\MessengerHandlerAlreadyExistsException;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerContainerInterface;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerHandler\MenuMessengerHandler;
use Look\Application\Messenger\MessengerHandler\SupportMessengerHandler;
use Look\Application\Messenger\MessengerHandler\WelcomeMessengerHandler;
use Look\Application\Messenger\MessengerInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardFactoryInterface;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Psr\Log\LoggerInterface;

class TelegramController extends Controller
{
    protected MessengerHandlerContainerInterface $handlers;

    public function __construct(
        protected MessengerInterface                 $messenger,
        protected MessengerContainerFactoryInterface $messengerContainerFactory,
        protected LoggerInterface                    $logger,
        protected MessengerKeyboardFactoryInterface  $keyboardFactory,
        protected MessengerButtonFactoryInterface    $buttonFactory,
        protected MessengerOptionFactoryInterface $optionFactory
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

        $this->addHandler(
            MessengerHandlerName::Support,
            MessengerHandlerType::Text,
            new SupportMessengerHandler()
        );

        $this->addHandler(
            MessengerHandlerName::AddSupportMessage,
            MessengerHandlerType::Message,
            new AddSupportMessengerHandler()
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
