<?php

declare(strict_types=1);

namespace Look\Domain\Value\Id\Trait;

use Look\Domain\Value\Id\Interface\IdInterface;

trait HasId
{
    protected ?IdInterface $id = null;

    public function getId(): ?IdInterface
    {
        return $this->id;
    }

    public function setId(?IdInterface $id): static
    {
        $this->id = $id;
        return $this;
    }
}
