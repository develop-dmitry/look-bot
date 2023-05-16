<?php

namespace Look\Domain\Clothes;

use Look\Domain\Clothes\Interface\ClothesInterface;
use Look\Domain\Value\Id\Trait\HasId;
use Look\Domain\Value\Name\Trait\HasName;
use Look\Domain\Value\Image\Trait\HasImage;

class Clothes implements ClothesInterface
{
    use HasId, HasImage, HasName;

    protected bool $isChosen;

    public function isChosen(): bool
    {
        return $this->isChosen;
    }

    public function setChosen(bool $isChosen): ClothesInterface
    {
        $this->isChosen = $isChosen;
        return $this;
    }
}
