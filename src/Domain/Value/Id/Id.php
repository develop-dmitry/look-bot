<?php

declare(strict_types=1);

namespace Look\Domain\Value\Id;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Id\Interface\IdInterface;

class Id implements IdInterface
{
    protected int $value;

    /**
     * @param int $value
     * @throws InvalidValueException
     */
    public function __construct(int $value)
    {
        $this->setValue($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->validate($value);

        $this->value = $value;
    }

    /**
     * @throws InvalidValueException
     */
    protected function validate(int $value): void
    {
        if ($value <= 0) {
            throw new InvalidValueException('ID must be more zero');
        }
    }
}
