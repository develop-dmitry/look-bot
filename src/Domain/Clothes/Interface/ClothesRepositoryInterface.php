<?php

declare(strict_types=1);

namespace Look\Domain\Clothes\Interface;

use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\Clothes\Exception\ClothesRepositoryException;
use Look\Domain\Clothes\Exception\ClothesNotFoundException;

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

    /**
     * @param int $clothesId
     * @return ClothesInterface
     * @throws ClothesNotFoundException
     * @throws ClothesRepositoryException
     */
    public function getClothes(int $clothesId): ClothesInterface;

    /**
     * @param ClientInterface $client
     * @param ClothesInterface $clothes
     * @return void
     * @throws ClothesNotFoundException
     * @throws ClothesRepositoryException
     */
    public function chooseClothes(ClientInterface $client, ClothesInterface $clothes): void;
}
