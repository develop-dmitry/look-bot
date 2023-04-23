<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option;

use Look\Domain\Messenger\Interface\OptionFactoryInterface;
use Look\Domain\Messenger\Interface\OptionInterface;
use Look\Domain\Messenger\Option\ButtonOption\ButtonOption;
use Look\Domain\Messenger\Option\ButtonOption\CallbackDataButtonOption;
use Look\Domain\Messenger\Option\ButtonOption\NullButtonOption;
use Look\Domain\Messenger\Option\KeyboardOption\NullKeyboardOption;
use Look\Domain\Messenger\Option\KeyboardOption\KeyboardOption;

class OptionFactory implements OptionFactoryInterface
{
    public function makeButtonOption(): OptionInterface
    {
        return new ButtonOption();
    }

    public function makeCallbackDataButtonOption(): OptionInterface
    {
        return new CallbackDataButtonOption();
    }

    public function makeNullButtonOption(): OptionInterface
    {
        return new NullButtonOption();
    }

    public function makeKeyboardOption(): OptionInterface
    {
        return new KeyboardOption();
    }

    public function makeNullKeyboardOption(): OptionInterface
    {
        return new NullKeyboardOption();
    }
}
