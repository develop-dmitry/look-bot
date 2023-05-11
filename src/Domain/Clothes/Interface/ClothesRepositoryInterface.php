<?php

declare(strict_types=1);

namespace Look\Domain\Clothes\Interface;

use Look\Domain\Client\Interface\ClientInterface;

interface ClothesRepositoryInterface
{
    /**
     * @param ClientInterface $client
     * @param int $perPage
     * @param int $page
     * @return ClothesPaginationInterface
     */
    public function getClothesForUser(
        ClientInterface $client,
        int $perPage = 10,
        int $page = 1
    ): ClothesPaginationInterface;
}
