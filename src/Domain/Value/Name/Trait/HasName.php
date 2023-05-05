<?php

declare(strict_types=1);

namespace Look\Domain\Value\Name\Trait;

use Look\Domain\Value\Name\Interface\NameInterface;

trait HasName
{
    protected NameInterface $name;

    public function getName(): NameInterface
    {
        return $this->name;
    }

    public function setName(NameInterface $name): static
    {
        $this->name = $name;
        return $this;
    }
}
