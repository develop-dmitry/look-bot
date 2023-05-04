<?php

declare(strict_types=1);

namespace Look\Domain\Value\Interface;

use Look\Domain\Value\Exception\InvalidValueException;

interface PhotoInterface
{
    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $photo
     * @return void
     * @throws InvalidValueException
     */
    public function setValue(string $photo): void;
}
