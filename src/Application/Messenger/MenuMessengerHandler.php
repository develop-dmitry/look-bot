<?php

declare(strict_types=1);

namespace Look\Application\Messenger;

use Look\Application\Messenger\Menu\FailedBuildMenuException;
use Look\Application\Messenger\Menu\HasMenu;
use Look\Application\Messenger\Menu\UseMenuInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\Messenger\Interface\ButtonFactoryInterface;
use Look\Domain\Messenger\Interface\KeyboardFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerHandlerInterface;
use Look\Domain\Messenger\Interface\MessengerInterface;
use Look\Domain\Messenger\Interface\MessengerRequestInterface;
use Look\Domain\Messenger\Interface\OptionFactoryInterface;
use Psr\Log\LoggerInterface;

class MenuMessengerHandler implements MessengerHandlerInterface, UseMenuInterface
{
    use HasMenu;

    public function __construct(
        protected LoggerInterface $logger,
        KeyboardFactoryInterface $keyboardFactory,
        ButtonFactoryInterface $buttonFactory,
        OptionFactoryInterface $optionFactory
    ) {
        $this->setKeyboardFactory($keyboardFactory);
        $this->setButtonFactory($buttonFactory);
        $this->setOptionFactory($optionFactory);
    }

    public function handle(
        MessengerRequestInterface $request,
        MessengerInterface $messenger,
        ClientInterface $client
    ): void {
        try {
            $messenger->sendMessage(__('telegram.menu_message'));
            $messenger->sendKeyboard($this->getMenuKeyboard());
        } catch (FailedBuildMenuException $exception) {
            $this->logger->emergency('Не удалось сформировать меню', ['exception' => $exception]);
            $messenger->sendTechnicalErrorMessage();
        }
    }
}
