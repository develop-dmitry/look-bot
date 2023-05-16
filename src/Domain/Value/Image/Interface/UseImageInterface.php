<?php

declare(strict_types=1);

namespace Look\Domain\Value\Image\Interface;

interface UseImageInterface
{
    /**
     * @return ImageInterface
     */
    public function getPhoto(): ImageInterface;

    /**
     * @param ImageInterface $photo
     * @return $this
     */
    public function setPhoto(ImageInterface $photo): static;
}
