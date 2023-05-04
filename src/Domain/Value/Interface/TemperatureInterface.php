<?php

declare(strict_types=1);

namespace Look\Domain\Value\Interface;

use Look\Domain\Value\Exception\InvalidValueException;

interface TemperatureInterface
{
    /**
     * @return int
     */
    public function getValue(): int;

    /**
     * @param int $temperature
     * @return void
     * @throws InvalidValueException
     */
    public function setValue(int $temperature): void;
}
