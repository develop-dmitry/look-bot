<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler\Enum;

enum MessengerHandlerType: string
{
    case Message = 'message';

    case Command = 'command';

    case CallbackQuery = 'callbackQuery';

    case Text = 'text';
}
