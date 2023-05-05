<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerKeyboard;

enum MessengerKeyboardType: string
{
    case Inline = 'inline';

    case Reply = 'reply';
}
