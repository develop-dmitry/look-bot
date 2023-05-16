<?php

declare(strict_types=1);

namespace Look\Application\Clothes\ChooseClothes\Interface;

interface ChooseClothesResponseInterface
{
    /**
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * @return string
     */
    public function getError(): string;
}
