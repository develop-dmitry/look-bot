<?php

declare(strict_types=1);

namespace Look\Domain\Builder\UseName;

trait HasName
{
    public function setName(string $name): static
    {
        $this->values['name'] = $name;
        return $this;
    }
}
