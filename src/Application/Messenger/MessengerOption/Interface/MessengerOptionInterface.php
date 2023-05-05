<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption\Interface;

use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionNameException;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionValueException;

interface MessengerOptionInterface
{
    /**
     * @param string $name
     * @return MessengerOptionInterface
     * @throws FailedSetOptionNameException
     */
    public function setName(string $name): MessengerOptionInterface;

    public function getName(): string;

    /**
     * @param mixed $value
     * @return MessengerOptionInterface
     * @throws FailedSetOptionValueException
     */
    public function setValue(mixed $value): MessengerOptionInterface;

    public function getValue(): mixed;

    public function isNullOption(): bool;
}
