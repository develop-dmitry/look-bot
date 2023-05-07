<?php

declare(strict_types=1);

namespace Look\Domain\Value\Address;

use Look\Domain\Value\Address\Interface\AddressInterface;
use Look\Domain\Value\Exception\InvalidValueException;

class Address implements AddressInterface
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
        $this->value = $value;
    }
}
