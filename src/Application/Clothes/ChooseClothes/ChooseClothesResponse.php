<?php

declare(strict_types=1);

namespace Look\Application\Clothes\ChooseClothes;

use Look\Application\Clothes\ChooseClothes\Interface\ChooseClothesResponseInterface;

class ChooseClothesResponse implements ChooseClothesResponseInterface
{
    public function __construct(
        protected bool $success,
        protected string $error = ''
    ) {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
