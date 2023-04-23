<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\User\Interface\UserInterface;

interface MessengerHandlerInterface
{
    public function handle(
        MessengerRequestInterface $request,
        MessengerInterface $messenger,
        ClientInterface $client
    ): void;
}
