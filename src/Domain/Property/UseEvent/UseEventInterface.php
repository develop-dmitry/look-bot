<?php

declare(strict_types=1);

namespace Look\Domain\Property\UseEvent;

use Look\Domain\Entity\Event\Interface\EventInterface;
use Look\Domain\Storage\Exception\StorageException;

interface UseEventInterface
{
    /**
     * @return EventInterface[]
     * @throws StorageException
     */
    public function getEvents(): array;

    /**
     * @param int ...$eventPrimary
     * @return $this
     */
    public function addEvents(int ...$eventPrimary): static;
}
