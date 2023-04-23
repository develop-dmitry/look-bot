<?php

declare(strict_types=1);

namespace Look\Domain\Messenger;

use Look\Domain\Messenger\Handler\MessengerHandlerContainer;
use Look\Domain\Messenger\Interface\MessengerContainerFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerHandlerContainerInterface;
use Look\Domain\Messenger\Interface\OptionContainerInterface;
use Look\Domain\Messenger\Interface\OptionFactoryInterface;
use Look\Domain\Messenger\Option\ButtonOption\ButtonOptionContainer;
use Look\Domain\Messenger\Option\KeyboardOption\KeyboardOptionContainer;

class MessengerContainerFactory implements MessengerContainerFactoryInterface
{
    public function __construct(
        protected OptionFactoryInterface $optionFactory
    ) {
    }

    public function makeButtonOptionContainer(): OptionContainerInterface
    {
        return new ButtonOptionContainer($this->optionFactory);
    }

    public function makeKeyboardOptionContainer(): OptionContainerInterface
    {
        return new KeyboardOptionContainer($this->optionFactory);
    }

    public function makeHandlerContainer(): MessengerHandlerContainerInterface
    {
        return new MessengerHandlerContainer();
    }
}
