<?php

declare(strict_types=1);

namespace Look\Application\Builder\UsePhoto;

interface UsePhotoInterface
{
    /**
     * @param string $photo
     * @return $this
     */
    public function setPhoto(string $photo): static;
}
