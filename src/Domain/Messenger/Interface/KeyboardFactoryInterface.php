<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

interface KeyboardFactoryInterface
{
    public function makeInlineKeyboard(): KeyboardInterface;

    public function makeReplyKeyboard(): KeyboardInterface;
}
