<?php

declare(strict_types=1);

namespace Look\Domain\Property\UseName;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Name;

trait HasName
{
    protected Name $name;

    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @throws InvalidValueException
     */
    public function setName(string $name): static
    {
        $this->name = $this->valueFactory->makeName($name);
        return $this;
    }
}
