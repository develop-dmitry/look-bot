<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Keyboard;

use Look\Domain\Messenger\Button\ButtonType;
use Look\Domain\Messenger\Interface\ButtonInterface;

class InlineKeyboard extends AbstractKeyboard
{
    protected function buttonCanBeAdded(ButtonInterface $button): bool
    {
        return $button->getType() === ButtonType::Inline;
    }

    public function getType(): KeyboardType
    {
        return KeyboardType::Inline;
    }
}
