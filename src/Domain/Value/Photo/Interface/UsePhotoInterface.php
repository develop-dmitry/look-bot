<?php

declare(strict_types=1);

namespace Look\Domain\Value\Photo\Interface;

interface UsePhotoInterface
{
    /**
     * @return PhotoInterface
     */
    public function getPhoto(): PhotoInterface;

    /**
     * @param PhotoInterface $photo
     * @return $this
     */
    public function setPhoto(PhotoInterface $photo): static;
}
