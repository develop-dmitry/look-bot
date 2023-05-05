<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerKeyboard\Interface;

interface MessengerKeyboardFactoryInterface
{
    public function makeInlineKeyboard(): MessengerKeyboardInterface;

    public function makeReplyKeyboard(): MessengerKeyboardInterface;
}
