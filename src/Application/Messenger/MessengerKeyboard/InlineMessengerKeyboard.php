<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerKeyboard;

use Look\Application\Messenger\MessengerButton\Interface\MessengerButtonInterfaceMessenger;
use Look\Application\Messenger\MessengerButton\MessengerButtonType;

class InlineMessengerKeyboard extends AbstractMessengerKeyboard
{
    protected function buttonCanBeAdded(MessengerButtonInterfaceMessenger $button): bool
    {
        return $button->getType() === MessengerButtonType::Inline;
    }

    public function getType(): MessengerKeyboardType
    {
        return MessengerKeyboardType::Inline;
    }
}
