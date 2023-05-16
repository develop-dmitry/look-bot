<?php

declare(strict_types=1);

namespace Look\Application\Clothes\ChooseClothes\Interface;

use Look\Domain\Client\Interface\ClientInterface;

interface ChooseClothesRequestInterface
{
    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface;

    /**
     * @return int
     */
    public function getClothesId(): int;
}
