<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Look\Interface;

use Look\Domain\Entity\Event\Interface\EventInterface;
use Look\Domain\Storage\Exception\StorageException;

interface LookRepositoryInterface
{
    /**
     * @param array $ids
     * @return EventInterface[]
     * @throws StorageException
     */
    public function getItemsById(array $ids): array;
}
