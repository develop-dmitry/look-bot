<?php

declare(strict_types=1);

namespace Look\Domain\Value\Coordinate\Interface;

use Look\Domain\Value\Exception\InvalidValueException;

interface CoordinateInterface
{
    /**
     * @return float
     */
    public function getValue(): float;

    /**
     * @param float $value
     * @return void
     * @throws InvalidValueException
     */
    public function setValue(float $value): void;
}
