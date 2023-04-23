<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

interface OptionFactoryInterface
{
    public function makeButtonOption(): OptionInterface;

    public function makeCallbackDataButtonOption(): OptionInterface;

    public function makeNullButtonOption(): OptionInterface;

    public function makeKeyboardOption(): OptionInterface;

    public function makeNullKeyboardOption(): OptionInterface;
}
