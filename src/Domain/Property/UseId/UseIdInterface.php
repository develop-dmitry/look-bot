<?php

declare(strict_types=1);

namespace Look\Domain\Property\UseId;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Id;

interface UseIdInterface
{
    /**
     * @return Id|null
     */
    public function getId(): ?Id;

    /**
     * @param int|null $id
     * @return $this
     * @throws InvalidValueException
     */
    public function setId(?int $id): static;
}
