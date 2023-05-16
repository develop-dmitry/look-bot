<?php

declare(strict_types=1);

namespace Look\Domain\Clothes\Interface;

interface ClothesPaginationInterface
{
    /**
     * @return ClothesInterface[]
     */
    public function getItems(): array;

    /**
     * @return int
     */
    public function getPage(): int;

    /**
     * @return int
     */
    public function getPageTotal(): int;

    /**
     * @return bool
     */
    public function hasNext(): bool;

    /**
     * @return bool
     */
    public function hasPrev(): bool;
}
