<?php

declare(strict_types=1);

namespace Look\Domain\Value\Coordinate;

use Look\Domain\Value\Coordinate\Interface\CoordinateInterface;
use Look\Domain\Value\Exception\InvalidValueException;

class Coordinate implements CoordinateInterface
{
    protected float $value;

    /**
     * @param float $value
     * @throws InvalidValueException
     */
    public function __construct(float $value)
    {
        $this->setValue($value);
    }


    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        // todo доделать валидацию
        $this->value = $value;
    }
}
