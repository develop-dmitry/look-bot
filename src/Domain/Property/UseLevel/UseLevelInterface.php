<?php

declare(strict_types=1);

namespace Look\Domain\Property\UseLevel;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Level;

interface UseLevelInterface
{
    /**
     * @return Level
     */
    public function getLevel(): Level;

    /**
     * @param int $level
     * @return $this
     * @throws InvalidValueException
     */
    public function setLevel(int $level): static;
}
