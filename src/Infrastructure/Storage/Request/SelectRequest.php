<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Request;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Repository\Interface\Parameter\Pagination\PaginationInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortInterface;
use Look\Domain\Storage\Interface\Request\SelectRequestInterface;

class SelectRequest implements SelectRequestInterface
{
    public function __construct(
        protected ?FilterInterface $filter,
        protected ?SortInterface $sort,
        protected ?PaginationInterface $pagination
    ) {
    }

    public function getFilter(): ?FilterInterface
    {
        return $this->filter;
    }

    public function getSort(): ?SortInterface
    {
        return $this->sort;
    }

    public function getPagination(): ?PaginationInterface
    {
        return $this->pagination;
    }
}
