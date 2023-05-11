<?php

declare(strict_types=1);

namespace Look\Domain\Value\Image;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Image\Interface\ImageInterface;

class Image implements ImageInterface
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

    public function getAbsolutePath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->value;
    }

    public function fileExists(): bool
    {
        return file_exists($this->getAbsolutePath());
    }
}
