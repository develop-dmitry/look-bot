<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerContainer;

use Look\Application\Messenger\MessengerContainer\Interface\MessengerContainerFactoryInterface;
use Look\Application\Messenger\MessengerContainer\Interface\MessengerOptionContainerInterface;
use Look\Application\Messenger\MessengerHandler\Container\MessengerHandlerContainer;
use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerContainerInterface;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;

class MessengerContainerFactory implements MessengerContainerFactoryInterface
{
    public function __construct(
        protected MessengerOptionFactoryInterface $optionFactory
    ) {
    }

    public function makeButtonOptionContainer(): MessengerOptionContainerInterface
    {
        return new MessengerButtonOptionContainer($this->optionFactory);
    }

    public function makeKeyboardOptionContainer(): MessengerOptionContainerInterface
    {
        return new MessengerKeyboardOptionContainer($this->optionFactory);
    }

    public function makeHandlerContainer(): MessengerHandlerContainerInterface
    {
        return new MessengerHandlerContainer();
    }
}
