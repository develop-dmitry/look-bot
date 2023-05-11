<?php

declare(strict_types=1);

namespace Look\Application\Clothes\GetClothesForClient;

use Look\Application\Clothes\GetClothesForClient\Interface\GetClothesForClientRequestInterface;
use Look\Domain\Client\Interface\ClientInterface;

class GetClothesForClientRequest implements GetClothesForClientRequestInterface
{
    public function __construct(
        protected ClientInterface $client,
        protected int $page,
        protected int $perPage
    ) {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
