<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption;

use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;

abstract class AbstractMessengerOption implements MessengerOptionInterface
{
    public function __construct(
        protected string $name,
        protected mixed $value
    ) {
    }

    public function setName(string $name): MessengerOptionInterface
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setValue(mixed $value): MessengerOptionInterface
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
