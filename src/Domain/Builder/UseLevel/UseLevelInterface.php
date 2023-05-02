<?php

declare(strict_types=1);

namespace Look\Domain\Builder\UseLevel;

interface UseLevelInterface
{
    /**
     * @param int $level
     * @return $this
     */
    public function setLevel(int $level): static;
}
