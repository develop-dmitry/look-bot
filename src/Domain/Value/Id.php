<?php

declare(strict_types=1);

namespace Look\Domain\Value;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Interface\IdInterface;

class Id implements IdInterface
{
    protected int $id;

    /**
     * @param int $id
     * @throws InvalidValueException
     */
    public function __construct(int $id)
    {
        $this->setValue($id);
    }

    public function getValue(): int
    {
        return $this->id;
    }

    public function setValue(int $id): void
    {
        $this->validate($id);

        $this->id = $id;
    }

    /**
     * @throws InvalidValueException
     */
    protected function validate(int $id): void
    {
        if ($id <= 0) {
            throw new InvalidValueException('ID must be more zero');
        }
    }
}
