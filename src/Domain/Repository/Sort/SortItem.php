<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Sort;

use Look\Domain\Repository\Interface\Parameter\Sort\SortItemInterface;

class SortItem implements SortItemInterface
{
    public function __construct(
        protected string $column,
        protected string $direction,
        protected int $priority
    ) {
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }
}
