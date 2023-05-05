<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption\MessengerKeyboardOption;

use Look\Application\Messenger\MessengerOption\AbstractMessengerNullOption;

class MessengerNullKeyboardOption extends AbstractMessengerNullOption
{
    public function __construct()
    {
        parent::__construct(MessengerKeyboardOptionName::Null->value, null);
    }
}
