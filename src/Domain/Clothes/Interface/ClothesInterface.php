<?php

declare(strict_types=1);

namespace Look\Domain\Clothes\Interface;

use Look\Domain\Value\Id\Interface\UseIdInterface;
use Look\Domain\Value\Name\Interface\UseNameInterface;
use Look\Domain\Value\Image\Interface\UseImageInterface;

interface ClothesInterface extends UseIdInterface, UseImageInterface, UseNameInterface
{
    /**
     * @return bool
     */
    public function isChosen(): bool;

    /**
     * @param bool $isChosen
     * @return self
     */
    public function setChosen(bool $isChosen): self;
}
