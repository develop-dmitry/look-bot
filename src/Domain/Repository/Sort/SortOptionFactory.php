<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Sort;

use Look\Domain\Repository\Interface\Parameter\Sort\SortItemInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortOptionFactoryInterface;

class SortOptionFactory implements SortOptionFactoryInterface
{
    public function makeSortItem(string $column, string $direction, int $priority): SortItemInterface
    {
        return new SortItem($column, $direction, $priority);
    }
}
