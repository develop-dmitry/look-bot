<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Clothes\Interface;

use Look\Domain\Storage\Exception\StorageException;

interface ClothesRepositoryInterface
{
    /**
     * @param array $ids
     * @return ClothesInterface[]
     * @throws StorageException
     */
    public function getItemsById(array $ids): array;
}
