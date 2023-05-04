<?php

declare(strict_types=1);

namespace Look\Domain\Property\UseEvent;

use Look\Domain\Entity\Event\Interface\EventInterface;

trait HasEvent
{
    /**
     * @var EventInterface[]
     */
    protected array $events = [];

    /**
     * @var int[]
     */
    protected array $getEventsQueue = [];

    public function getEvents(): array
    {
        if (!empty($this->getEventsQueue)) {
            foreach ($this->eventRepository->getItemsById($this->getEventsQueue) as $style) {
                $this->events[] = $style;
            }

            $this->getEventsQueue = [];
        }

        return $this->events;
    }

    public function addEvents(int ...$eventPrimary): static
    {
        $this->getEventsQueue = array_merge($this->getEventsQueue, $eventPrimary);

        return $this;
    }
}
