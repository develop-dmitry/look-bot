<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption;

use Look\Application\Messenger\MessengerOption\MessengerButtonOption\MessengerButtonOption;
use Look\Application\Messenger\MessengerOption\MessengerButtonOption\MessengerCallbackDataButtonOption;
use Look\Application\Messenger\MessengerOption\MessengerButtonOption\MessengerNullButtonOption;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionFactoryInterface;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;
use Look\Application\Messenger\MessengerOption\MessengerKeyboardOption\MessengerKeyboardOption;
use Look\Application\Messenger\MessengerOption\MessengerKeyboardOption\MessengerNullKeyboardOption;

class MessengerOptionFactory implements MessengerOptionFactoryInterface
{
    public function makeButtonOption(): MessengerOptionInterface
    {
        return new MessengerButtonOption();
    }

    public function makeCallbackDataButtonOption(): MessengerOptionInterface
    {
        return new MessengerCallbackDataButtonOption();
    }

    public function makeNullButtonOption(): MessengerOptionInterface
    {
        return new MessengerNullButtonOption();
    }

    public function makeKeyboardOption(): MessengerOptionInterface
    {
        return new MessengerKeyboardOption();
    }

    public function makeNullKeyboardOption(): MessengerOptionInterface
    {
        return new MessengerNullKeyboardOption();
    }
}
