<?php

declare(strict_types=1);

namespace Look\Domain\Value\Id\Interface;

use Look\Domain\Value\Exception\InvalidValueException;

interface IdInterface
{
    /**
     * @return int
     */
    public function getValue(): int;

    /**
     * @param int $value
     * @return void
     * @throws InvalidValueException
     */
    public function setValue(int $value): void;
}
