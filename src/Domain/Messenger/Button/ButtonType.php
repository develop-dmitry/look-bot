<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Button;

enum ButtonType: string
{
    case Reply = 'reply';

    case Inline = 'inline';
}
