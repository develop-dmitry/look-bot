<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Style\Interface;

use Look\Domain\Entity\Event\Interface\EventInterface;
use Look\Domain\Storage\Exception\StorageException;

interface StyleRepositoryInterface
{
    /**
     * @param array $ids
     * @return EventInterface[]
     * @throws StorageException
     */
    public function getItemsById(array $ids): array;
}
