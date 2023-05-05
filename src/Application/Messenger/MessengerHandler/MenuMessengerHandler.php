<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonFactoryInterface;
use Look\Application\Messenger\MessengerContext\MessengerContextInterface;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerInterface;
use Look\Application\Messenger\MessengerHandler\Trait\Menu\FailedBuildMenuException;
use Look\Application\Messenger\MessengerHandler\Trait\Menu\HasMenu;
use Look\Application\Messenger\MessengerHandler\Trait\Menu\UseMenuInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardFactoryInterface;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Messenger\MessengerVisual\MessengerVisualInterface;
use Psr\Log\LoggerInterface;

class MenuMessengerHandler implements MessengerHandlerInterface, UseMenuInterface
{
    use HasMenu;

    public function __construct(
        protected LoggerInterface $logger,
        protected MessengerKeyboardFactoryInterface $keyboardFactory,
        protected MessengerButtonFactoryInterface $buttonFactory,
        protected MessengerOptionFactoryInterface $optionFactory
    ) {
    }

    public function handle(MessengerContextInterface $context, MessengerVisualInterface $visual): void
    {
        try {
            $visual->sendMessage(__('telegram.menu_message'));
            $visual->sendKeyboard($this->getMenuKeyboard());
        } catch (FailedBuildMenuException $exception) {
            $this->logger->emergency('Не удалось сформировать меню', ['exception' => $exception]);
        }
    }
}
