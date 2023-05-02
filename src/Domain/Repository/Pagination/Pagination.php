<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Pagination;

use Look\Domain\Repository\Interface\Parameter\Pagination\PaginationInterface;

class Pagination implements PaginationInterface
{
    public function __construct(
        protected int $page = 1,
        protected int $count = 20
    ) {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): PaginationInterface
    {
        $this->page = $page;
        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): PaginationInterface
    {
        $this->count = $count;
        return $this;
    }
}
