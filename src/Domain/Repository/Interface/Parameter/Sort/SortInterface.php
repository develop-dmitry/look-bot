<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter\Sort;

interface SortInterface
{
    /**
     * @param string $column
     * @param string $direction
     * @param int $priority
     * @return self
     */
    public function addSort(string $column, string $direction = 'asc', int $priority = 1): self;

    /**
     * @return SortItemInterface[]
     */
    public function getSorts(): array;
}
