<?php

declare(strict_types=1);

namespace Look\Domain\Value;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Interface\NameInterface;

class Name implements NameInterface
{
    protected string $value;

    /**
     * @param string $value
     * @throws InvalidValueException
     */
    public function __construct(string $value)
    {
        $this->setValue($value);
    }


    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $name): void
    {
        $this->validate($name);
        $this->value = $name;
    }

    /**
     * @throws InvalidValueException
     */
    protected function validate(string $name): void
    {
        if (strlen($name) <= 0) {
            throw new InvalidValueException('Name must not be empty');
        }

        if (strlen($name) > 255) {
            throw new InvalidValueException('Name must be shorter than 255 symbols');
        }
    }
}
