<?php

declare(strict_types=1);

namespace Look\Domain\Value\Name\Interface;

use Look\Domain\Value\Exception\InvalidValueException;

interface NameInterface
{
    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $value
     * @return void
     * @throws InvalidValueException
     */
    public function setValue(string $value): void;
}
