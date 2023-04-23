<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option;

use Look\Domain\Messenger\Interface\OptionInterface;

abstract class AbstractOption implements OptionInterface
{
    public function __construct(
        protected string $name,
        protected mixed $value
    ) {
    }

    public function setName(string $name): OptionInterface
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setValue(mixed $value): OptionInterface
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function isNullOption(): bool
    {
        return false;
    }
}
