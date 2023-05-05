<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerButton;

enum MessengerButtonType: string
{
    case Reply = 'reply';

    case Inline = 'inline';
}
