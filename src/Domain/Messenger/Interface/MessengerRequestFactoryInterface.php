<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

interface MessengerRequestFactoryInterface
{
    public function makeMessengerRequest(): MessengerRequestInterface;
}
