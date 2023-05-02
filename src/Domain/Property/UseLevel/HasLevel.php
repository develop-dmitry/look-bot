<?php

declare(strict_types=1);

namespace Look\Domain\Property\UseLevel;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Level;

trait HasLevel
{
    protected Level $level;

    public function getLevel(): Level
    {
        return $this->level;
    }

    /**
     * @throws InvalidValueException
     */
    public function setLevel(int $level): static
    {
        $this->level = $this->valueFactory->makeLevel($level);
        return $this;
    }
}
