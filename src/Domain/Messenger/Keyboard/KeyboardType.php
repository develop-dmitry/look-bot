<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Keyboard;

enum KeyboardType: string
{
    case Inline = 'inline';

    case Reply = 'reply';
}
