<?php

declare(strict_types=1);

namespace Look\Domain\Value;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Interface\PhotoInterface;

class Photo implements PhotoInterface
{
    protected string $photo;

    /**
     * @throws InvalidValueException
     */
    public function __construct(string $photo)
    {
        $this->setValue($photo);
    }

    public function getValue(): string
    {
        return $this->photo;
    }

    public function setValue(string $photo): void
    {
        // todo добавить проверку на корректность ссылки
        $this->photo = $photo;
    }
}
