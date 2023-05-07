<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler;

use Look\Application\Dictionary\DictionaryInterface;
use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerHandler\Trait\UseMainMenu\HasMainMenu;
use Look\Application\Messenger\MessengerHandler\Trait\UseMainMenu\UseMainMenuInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardFactoryInterface;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;
use Psr\Log\LoggerInterface;

class WelcomeMessengerHandler implements MessengerHandlerInterface, UseMainMenuInterface
{
    use HasMainMenu;

    public function __construct(
        protected LoggerInterface $logger,
        protected MessengerKeyboardFactoryInterface $keyboardFactory,
        protected MessengerButtonFactoryInterface $buttonFactory,
        protected MessengerOptionFactoryInterface $optionFactory,
        protected DictionaryInterface $dictionary
    ) {
    }

    public function handle(MessengerContextInterface $context, MessengerVisualInterface $visual): void
    {
        $visual->sendMessage($this->dictionary->getTranslate('telegram.welcome_message'));
        $visual->sendKeyboard($this->getMainMenuKeyboard());
    }

    public function getTypes(): array
    {
        return [MessengerHandlerType::Command];
    }

    public function getNames(): array
    {
        return [MessengerHandlerName::Start];
    }
}
