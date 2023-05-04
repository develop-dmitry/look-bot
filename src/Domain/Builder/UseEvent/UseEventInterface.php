<?php

declare(strict_types=1);

namespace Look\Domain\Builder\UseEvent;

interface UseEventInterface
{
    public function addEventPrimaries(int ...$evenPrimaries): static;
}
