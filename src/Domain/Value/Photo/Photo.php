<?php

declare(strict_types=1);

namespace Look\Domain\Value\Photo;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Photo\Interface\PhotoInterface;

class Photo implements PhotoInterface
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
        // todo добавить проверку на корректность ссылки
        $this->value = $value;
    }
}
