<?php

declare(strict_types=1);

namespace Look\Domain\Value\Temperature;

use Look\Domain\Value\Exception\InvalidValueException;

class Temperature implements TemperatureInterface
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

    public function getFormatValue(): string
    {
        return (($this->value > 0) ? "+$this->value" : (string) $this->value) . '℃';
    }

    public function setValue(int $value): void
    {
        $this->validate($value);

        $this->value = $value;
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
