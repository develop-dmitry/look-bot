<?php

declare(strict_types=1);

namespace Look\Domain\Repository;

use Look\Domain\Repository\Filter\Filter;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterOptionFactoryInterface;
use Look\Domain\Repository\Interface\Parameter\Pagination\PaginationInterface;
use Look\Domain\Repository\Interface\Parameter\ParameterFactoryInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortOptionFactoryInterface;
use Look\Domain\Repository\Pagination\Pagination;
use Look\Domain\Repository\Sort\Sort;

class ParameterFactory implements ParameterFactoryInterface
{
    public function __construct(
        protected FilterOptionFactoryInterface $filterOptionFactory,
        protected SortOptionFactoryInterface $sortOptionFactory
    ) {
    }

    public function makeFilter(): FilterInterface
    {
        return new Filter($this->filterOptionFactory);
    }

    public function makePagination(): PaginationInterface
    {
        return new Pagination();
    }

    public function makeSort(): SortInterface
    {
        return new Sort($this->sortOptionFactory);
    }
}
