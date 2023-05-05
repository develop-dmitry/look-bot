<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerRequest\Interface;

interface MessengerRequestFactoryInterface
{
    public function makeMessengerRequest(): MessengerRequestInterface;
}
