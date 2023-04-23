<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

interface MessengerContainerFactoryInterface
{
    public function makeButtonOptionContainer(): OptionContainerInterface;

    public function makeKeyboardOptionContainer(): OptionContainerInterface;

    public function makeHandlerContainer(): MessengerHandlerContainerInterface;
}
