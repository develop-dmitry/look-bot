<?php

declare(strict_types=1);

namespace Look\Application\Client\SaveClient;

use Look\Application\Client\SaveClient\Interface\SaveClientRequestInterface;
use Look\Domain\Client\Interface\ClientInterface;

class SaveClientRequest implements SaveClientRequestInterface
{
    public function __construct(
        protected ClientInterface $client
    ) {
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }
}
