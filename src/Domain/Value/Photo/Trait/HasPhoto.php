<?php

declare(strict_types=1);

namespace Look\Domain\Value\Photo\Trait;

use Look\Domain\Value\Photo\Interface\PhotoInterface;

trait HasPhoto
{
    protected PhotoInterface $photo;

    public function getPhoto(): PhotoInterface
    {
        return $this->photo;
    }

    /**
     * @param PhotoInterface $photo
     * @return $this
     */
    public function setPhoto(PhotoInterface $photo): static
    {
        $this->photo = $photo;
        return $this;
    }
}
