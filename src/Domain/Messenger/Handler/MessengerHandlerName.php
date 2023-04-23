<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Handler;

enum MessengerHandlerName: string
{
    case Start = 'start';

    case Menu = 'menu';
}
