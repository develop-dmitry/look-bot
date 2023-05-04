<?php

declare(strict_types=1);

namespace Look\Domain\Builder\UseEvent;

trait HasEvent
{
    public function addEventPrimaries(int ...$evenPrimaries): static
    {
        $this->values['event_primaries'] = array_merge($this->getValue('event_primaries', []), $evenPrimaries);
        return $this;
    }
}
