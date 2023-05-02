<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Repository\Interface\Parameter\Pagination\PaginationInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortInterface;

interface ParameterFactoryInterface
{
    public function makeFilter(): FilterInterface;

    public function makePagination(): PaginationInterface;

    public function makeSort(): SortInterface;
}
