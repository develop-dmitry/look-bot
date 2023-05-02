<?php

declare(strict_types=1);

namespace Look\Domain\Property\UsePhoto;

use Look\Domain\Value\Photo;

interface UsePhotoInterface
{
    /**
     * @return Photo
     */
    public function getPhoto(): Photo;

    /**
     * @param string $photo
     * @return $this
     */
    public function setPhoto(string $photo): static;
}
