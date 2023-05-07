<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Look\Application\Client\SaveClient\Interface\SaveClientInterface;
use Look\Application\Dictionary\DictionaryInterface;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerContainer\Interface\MessengerContainerFactoryInterface;
use Look\Application\Messenger\MessengerHandler\AddSupportMessengerHandler;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Exception\MessengerHandlerAlreadyExistsException;
use Look\Application\Messenger\MessengerHandler\GetWeatherMessengerHandler;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerContainerInterface;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerHandler\MenuMessengerHandler;
use Look\Application\Messenger\MessengerHandler\SupportMessengerHandler;
use Look\Application\Messenger\MessengerHandler\WelcomeMessengerHandler;
use Look\Application\Messenger\MessengerInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardFactoryInterface;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Weather\GetWeather\Interface\GetWeatherInterface;
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
        protected MessengerOptionFactoryInterface    $optionFactory,
        protected GetWeatherInterface                $getWeather,
        protected SaveClientInterface                $saveClient,
        protected DictionaryInterface                $dictionary
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
                $this->optionFactory,
                $this->dictionary
            )
        );

        $this->addHandler(
            MessengerHandlerName::Menu,
            MessengerHandlerType::Command,
            new MenuMessengerHandler(
                $this->logger,
                $this->keyboardFactory,
                $this->buttonFactory,
                $this->optionFactory,
                $this->dictionary
            )
        );

        $this->addHandler(
            MessengerHandlerName::Support,
            MessengerHandlerType::Text,
            new SupportMessengerHandler($this->dictionary)
        );

        $this->addHandler(
            MessengerHandlerName::AddSupportMessage,
            MessengerHandlerType::Message,
            new AddSupportMessengerHandler($this->dictionary)
        );

        $getWeatherMessengerHandler = new GetWeatherMessengerHandler(
            $this->getWeather,
            $this->optionFactory,
            $this->keyboardFactory,
            $this->buttonFactory,
            $this->saveClient,
            $this->logger,
            $this->dictionary
        );

        $this->addHandler(
            MessengerHandlerName::GetWeatherText,
            MessengerHandlerType::Text,
            $getWeatherMessengerHandler
        );

        $this->addHandler(
            MessengerHandlerName::GetWeatherText,
            MessengerHandlerType::Message,
            $getWeatherMessengerHandler
        );

        $this->addHandler(
            MessengerHandlerName::GetWeatherCallbackQuery,
            MessengerHandlerType::CallbackQuery,
            $getWeatherMessengerHandler
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
