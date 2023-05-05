<?php

declare(strict_types=1);

namespace Look\Application\Client\IdentifyClient;

use Look\Application\Client\IdentifyClient\Interface\IdentifyClientResponseInterface;
use Look\Domain\Client\Interface\ClientInterface;

class IdentifyClientResponse implements IdentifyClientResponseInterface
{
    public function __construct(
        protected bool $identified,
        protected string $error,
        protected ?ClientInterface $client = null
    ) {
    }

    public function isIdentified(): bool
    {
        return $this->identified;
    }

    public function getClient(): ?ClientInterface
    {
        return $this->client;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
