<?php

declare(strict_types=1);

namespace Look\Application\Clothes\ChooseClothes;

use Look\Application\Clothes\ChooseClothes\Interface\ChooseClothesRequestInterface;
use Look\Domain\Client\Interface\ClientInterface;

class ChooseClothesRequest implements ChooseClothesRequestInterface
{
    public function __construct(
        protected ClientInterface $client,
        protected int $clothesId
    ) {
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function getClothesId(): int
    {
        return $this->clothesId;
    }
}
