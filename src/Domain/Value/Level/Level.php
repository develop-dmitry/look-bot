<?php

declare(strict_types=1);

namespace Look\Domain\Value\Level;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Level\Interface\LevelInterface;

class Level implements LevelInterface
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
            throw new InvalidValueException('Level must be more zero');
        }

        if ($value > 100) {
            throw new InvalidValueException('Level must be less 100');
        }
    }
}
