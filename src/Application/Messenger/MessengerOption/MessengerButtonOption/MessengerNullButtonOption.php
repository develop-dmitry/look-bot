<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption\MessengerButtonOption;

use Look\Application\Messenger\MessengerOption\AbstractMessengerNullOption;

class MessengerNullButtonOption extends AbstractMessengerNullOption
{
    public function __construct()
    {
        parent::__construct(MessengerButtonOptionName::Null->value, null);
    }
}
