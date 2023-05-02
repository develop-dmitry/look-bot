<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter\Sort;

interface SortOptionFactoryInterface
{
    public function makeSortItem(string $column, string $direction, int $priority): SortItemInterface;
}
