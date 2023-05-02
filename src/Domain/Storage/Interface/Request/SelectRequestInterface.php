<?php

declare(strict_types=1);

namespace Look\Domain\Storage\Interface\Request;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Repository\Interface\Parameter\Pagination\PaginationInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortInterface;

interface SelectRequestInterface
{
    /**
     * @return FilterInterface|null
     */
    public function getFilter(): ?FilterInterface;

    /**
     * @return SortInterface|null
     */
    public function getSort(): ?SortInterface;

    /**
     * @return PaginationInterface|null
     */
    public function getPagination(): ?PaginationInterface;
}
