<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Keyboard;

use Look\Domain\Messenger\Interface\KeyboardFactoryInterface;
use Look\Domain\Messenger\Interface\KeyboardInterface;
use Look\Domain\Messenger\Interface\MessengerContainerFactoryInterface;

class KeyboardFactory implements KeyboardFactoryInterface
{
    public function __construct(
        protected MessengerContainerFactoryInterface $messengerContainerFactory
    ) {
    }

    public function makeInlineKeyboard(): KeyboardInterface
    {
        return new InlineKeyboard($this->messengerContainerFactory->makeKeyboardOptionContainer());
    }

    public function makeReplyKeyboard(): KeyboardInterface
    {
        return new ReplyKeyboard($this->messengerContainerFactory->makeKeyboardOptionContainer());
    }
}
