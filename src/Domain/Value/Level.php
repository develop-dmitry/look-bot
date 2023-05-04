<?php

declare(strict_types=1);

namespace Look\Domain\Value;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Interface\LevelInterface;

class Level implements LevelInterface
{
    protected int $level;

    /**
     * @param int $level
     * @throws InvalidValueException
     */
    public function __construct(int $level)
    {
        $this->setValue($level);
    }

    public function getValue(): int
    {
        return $this->level;
    }

    public function setValue(int $level): void
    {
        $this->validate($level);

        $this->level = $level;
    }

    /**
     * @throws InvalidValueException
     */
    protected function validate(int $level): void
    {
        if ($level <= 0) {
            throw new InvalidValueException('Level must be more zero');
        }

        if ($level > 100) {
            throw new InvalidValueException('Level must be less 100');
        }
    }
}
