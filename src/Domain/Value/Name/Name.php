<?php

declare(strict_types=1);

namespace Look\Domain\Value\Name;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Name\Interface\NameInterface;

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

    public function setValue(string $value): void
    {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * @throws InvalidValueException
     */
    protected function validate(string $value): void
    {
        if (strlen($value) <= 0) {
            throw new InvalidValueException('Name must not be empty');
        }

        if (strlen($value) > 255) {
            throw new InvalidValueException('Name must be shorter than 255 symbols');
        }
    }
}
