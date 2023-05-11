<?php

declare(strict_types=1);

namespace Look\Domain\Value\Image\Interface;

use Look\Domain\Value\Exception\InvalidValueException;

interface ImageInterface
{
    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $value
     * @return void
     * @throws InvalidValueException
     */
    public function setValue(string $value): void;

    /**
     * @return string
     */
    public function getAbsolutePath(): string;

    /**
     * @return bool
     */
    public function fileExists(): bool;
}
