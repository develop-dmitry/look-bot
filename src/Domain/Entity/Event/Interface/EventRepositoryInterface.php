<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Event\Interface;

use Look\Domain\Storage\Exception\StorageException;

interface EventRepositoryInterface
{
    /**
     * @param array $ids
     * @return EventInterface[]
     * @throws StorageException
     */
    public function getItemsById(array $ids): array;
}
