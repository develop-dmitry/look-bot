<?php

declare(strict_types=1);

namespace Look\Domain\Property\UseId;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Id;

trait HasId
{
    protected ?Id $id = null;

    public function getId(): ?Id
    {
        return $this->id;
    }

    /**
     * @throws InvalidValueException
     */
    public function setId(?int $id): static
    {
        $this->id = ($id) ? $this->valueFactory->makeId($id) : null;
        return $this;
    }
}
