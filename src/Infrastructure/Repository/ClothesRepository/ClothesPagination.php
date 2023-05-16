<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository\ClothesRepository;

use Look\Domain\Clothes\Interface\ClothesPaginationInterface;

class ClothesPagination implements ClothesPaginationInterface
{
    public function __construct(
        protected array $items,
        protected int $page,
        protected int $pageTotal
    ) {
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPageTotal(): int
    {
        return $this->pageTotal;
    }

    public function hasNext(): bool
    {
        return $this->page + 1 < $this->pageTotal;
    }

    public function hasPrev(): bool
    {
        return $this->page - 1 > 0;
    }
}
