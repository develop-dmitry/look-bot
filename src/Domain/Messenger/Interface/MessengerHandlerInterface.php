<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Entity\Client\Interface\ClientInterface;

interface MessengerHandlerInterface
{
    public function handle(
        MessengerRequestInterface $request,
        MessengerInterface $messenger,
        ClientInterface $client
    ): void;
}
