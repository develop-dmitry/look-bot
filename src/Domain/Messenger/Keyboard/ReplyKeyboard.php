<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Keyboard;

use Look\Domain\Messenger\Button\ButtonType;
use Look\Domain\Messenger\Interface\ButtonInterface;

class ReplyKeyboard extends AbstractKeyboard
{
    protected function buttonCanBeAdded(ButtonInterface $button): bool
    {
        return $button->getType() === ButtonType::Reply;
    }

    public function getType(): KeyboardType
    {
        return KeyboardType::Reply;
    }
}
