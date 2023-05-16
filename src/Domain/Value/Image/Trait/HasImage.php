<?php

declare(strict_types=1);

namespace Look\Domain\Value\Image\Trait;

use Look\Domain\Value\Image\Interface\ImageInterface;

trait HasImage
{
    protected ImageInterface $photo;

    public function getPhoto(): ImageInterface
    {
        return $this->photo;
    }

    /**
     * @param ImageInterface $photo
     * @return $this
     */
    public function setPhoto(ImageInterface $photo): static
    {
        $this->photo = $photo;
        return $this;
    }
}
