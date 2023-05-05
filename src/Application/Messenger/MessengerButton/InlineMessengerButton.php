<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerButton;

class InlineMessengerButton extends AbstractMessengerButton
{
    public function getType(): MessengerButtonType
    {
        return MessengerButtonType::Inline;
    }
}
