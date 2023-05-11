<?php

declare(strict_types=1);

namespace Look\Application\Clothes\GetClothesForClient\Interface;

use Look\Domain\Client\Interface\ClientInterface;

interface GetClothesForClientRequestInterface
{
    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface;

    /**
     * @return int
     */
    public function getPage(): int;

    /**
     * @return int
     */
    public function getPerPage(): int;
}
