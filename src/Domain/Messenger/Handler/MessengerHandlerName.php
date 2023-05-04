<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Handler;

enum MessengerHandlerName: string
{
    case Start = 'start';

    case Menu = 'menu';

    case Support = 'Сообщить о проблеме';

    case AddSupportMessage = 'add_support_message';
}
