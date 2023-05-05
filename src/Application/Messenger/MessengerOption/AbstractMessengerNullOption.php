<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption;

use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionNameException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionValueException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;

class AbstractMessengerNullOption extends AbstractMessengerOption
{
    public function setName(string $name): MessengerOptionInterface
    {
        throw new FailedSetOptionNameException('Could not set name for null option');
    }

    public function setValue(mixed $value): MessengerOptionInterface
    {
        throw new FailedSetOptionValueException('Could not set value for null option');
    }

    public function isNullOption(): bool
    {
        return true;
    }
}
