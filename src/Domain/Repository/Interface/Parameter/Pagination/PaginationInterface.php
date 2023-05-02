<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter\Pagination;

interface PaginationInterface
{
    /**
     * @return int
     */
    public function getPage(): int;

    /**
     * @param int $page
     * @return self
     */
    public function setPage(int $page): self;

    /**
     * @return int
     */
    public function getCount(): int;

    /**
     * @param int $count
     * @return self
     */
    public function setCount(int $count): self;
}
