<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerKeyboard;

use Look\Application\Messenger\MessengerContainer\Interface\MessengerContainerFactoryInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardFactoryInterface;
use Look\Application\Messenger\MessengerKeyboard\Interface\MessengerKeyboardInterface;

class MessengerKeyboardFactory implements MessengerKeyboardFactoryInterface
{
    public function __construct(
        protected MessengerContainerFactoryInterface $messengerContainerFactory
    ) {
    }

    public function makeInlineKeyboard(): MessengerKeyboardInterface
    {
        return new InlineMessengerKeyboard($this->messengerContainerFactory->makeKeyboardOptionContainer());
    }

    public function makeReplyKeyboard(): MessengerKeyboardInterface
    {
        return new ReplyMessengerKeyboard($this->messengerContainerFactory->makeKeyboardOptionContainer());
    }
}
