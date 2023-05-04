<?php

declare(strict_types=1);

namespace Look\Domain\Property\UseName;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Name;

interface UseNameInterface
{
    /**
     * @return Name
     */
    public function getName(): Name;

    /**
     * @param string $name
     * @return $this
     * @throws InvalidValueException
     */
    public function setName(string $name): static;
}
