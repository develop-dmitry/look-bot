<?php

declare(strict_types=1);

namespace Look\Application\Clothes\GetClothesForClient\Interface;

use Look\Domain\Clothes\Interface\ClothesPaginationInterface;

interface GetClothesForClientResponseInterface
{
    /**
     * @return ClothesPaginationInterface
     */
    public function getClothes(): ClothesPaginationInterface;

    /**
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * @return string
     */
    public function getError(): string;
}
