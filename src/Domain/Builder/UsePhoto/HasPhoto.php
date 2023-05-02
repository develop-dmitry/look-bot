<?php

declare(strict_types=1);

namespace Look\Domain\Builder\UsePhoto;

trait HasPhoto
{
    public function setPhoto(string $photo): static
    {
        $this->values['photo'] = $photo;
        return $this;
    }
}
