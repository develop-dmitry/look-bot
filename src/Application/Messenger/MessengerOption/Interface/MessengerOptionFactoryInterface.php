<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption\Interface;

interface MessengerOptionFactoryInterface
{
    public function makeButtonOption(): MessengerOptionInterface;

    public function makeCallbackDataButtonOption(): MessengerOptionInterface;

    public function makeNullButtonOption(): MessengerOptionInterface;

    public function makeKeyboardOption(): MessengerOptionInterface;

    public function makeNullKeyboardOption(): MessengerOptionInterface;
}
