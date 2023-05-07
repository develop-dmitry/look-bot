<?php

declare(strict_types=1);

namespace Look\Domain\Value\Message;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Message\Interface\MessageInterface;

class Message implements MessageInterface
{
    protected string $value;

    /**
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
        $this->value = htmlspecialchars($value);
    }
}
