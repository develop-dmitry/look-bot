<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option;

use Look\Domain\Messenger\Exception\FailedSetOptionNameException;
use Look\Domain\Messenger\Exception\FailedSetOptionValueException;
use Look\Domain\Messenger\Interface\OptionInterface;

class AbstractNullOption extends AbstractOption
{
    public function setName(string $name): OptionInterface
    {
        throw new FailedSetOptionNameException('Could not set name for null option');
    }

    public function setValue(mixed $value): OptionInterface
    {
        throw new FailedSetOptionValueException('Could not set value for null option');
    }

    public function isNullOption(): bool
    {
        return true;
    }
}
