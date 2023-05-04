<?php

declare(strict_types=1);

namespace Look\Domain\Value;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Interface\TemperatureInterface;

class Temperature implements TemperatureInterface
{
    protected int $temperature;

    /**
     * @param int $temperature
     * @throws InvalidValueException
     */
    public function __construct(int $temperature)
    {
        $this->setValue($temperature);
    }

    public function getValue(): int
    {
        return $this->temperature;
    }

    public function setValue(int $temperature): void
    {
        $this->validate($temperature);

        $this->temperature = $temperature;
    }

    /**
     * @throws InvalidValueException
     */
    protected function validate(int $temperature): void
    {
        if ($temperature < -50) {
            throw new InvalidValueException('Temperature must be more -50');
        }

        if ($temperature > 50) {
            throw new InvalidValueException('Level must be less 50');
        }
    }
}
