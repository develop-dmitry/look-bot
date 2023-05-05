<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerContainer\Interface;

use Look\Application\Messenger\MessengerHandler\Interface\MessengerHandlerContainerInterface;

interface MessengerContainerFactoryInterface
{
    public function makeButtonOptionContainer(): MessengerOptionContainerInterface;

    public function makeKeyboardOptionContainer(): MessengerOptionContainerInterface;

    public function makeHandlerContainer(): MessengerHandlerContainerInterface;
}
