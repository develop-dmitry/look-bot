<?php

declare(strict_types=1);

namespace Look\Domain\Value\Interface;

use Look\Domain\Value\Exception\InvalidValueException;

interface IdInterface
{
    /**
     * @return int
     */
    public function getValue(): int;

    /**
     * @param int $id
     * @return void
     * @throws InvalidValueException
     */
    public function setValue(int $id): void;
}
