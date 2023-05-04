<?php

declare(strict_types=1);

namespace Look\Domain\Property\UsePhoto;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Photo;

trait HasPhoto
{
    protected Photo $photo;

    public function getPhoto(): Photo
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     * @return $this
     * @throws InvalidValueException
     */
    public function setPhoto(string $photo): static
    {
        $this->photo = $this->valueFactory->makePhoto($photo);
        return $this;
    }
}
