<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerRequest;

use Look\Application\Messenger\MessengerRequest\Interface\MessengerRequestFactoryInterface;
use Look\Application\Messenger\MessengerRequest\Interface\MessengerRequestInterface;

class MessengerRequestFactory implements MessengerRequestFactoryInterface
{
    public function makeMessengerRequest(): MessengerRequestInterface
    {
        return new MessengerRequest();
    }
}
