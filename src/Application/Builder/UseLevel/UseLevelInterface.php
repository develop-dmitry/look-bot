<?php

declare(strict_types=1);

namespace Look\Application\Builder\UseLevel;

interface UseLevelInterface
{
    /**
     * @param int $level
     * @return $this
     */
    public function setLevel(int $level): static;
}
