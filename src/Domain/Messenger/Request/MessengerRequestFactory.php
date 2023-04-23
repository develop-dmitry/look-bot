<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Request;

use Look\Domain\Messenger\Interface\MessengerRequestFactoryInterface;
use Look\Domain\Messenger\Interface\MessengerRequestInterface;

class MessengerRequestFactory implements MessengerRequestFactoryInterface
{
    public function makeMessengerRequest(): MessengerRequestInterface
    {
        return new MessengerRequest();
    }
}
