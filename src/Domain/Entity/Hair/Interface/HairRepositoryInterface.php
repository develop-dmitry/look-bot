<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Hair\Interface;

use Look\Domain\Entity\Event\Interface\EventInterface;
use Look\Domain\Storage\Exception\StorageException;

interface HairRepositoryInterface
{
    /**
     * @param array $ids
     * @return EventInterface[]
     * @throws StorageException
     */
    public function getItemsById(array $ids): array;
}
