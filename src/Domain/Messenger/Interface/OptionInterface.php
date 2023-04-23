<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Messenger\Exception\FailedSetOptionNameException;
use Look\Domain\Messenger\Exception\FailedSetOptionValueException;

interface OptionInterface
{
    /**
     * @param string $name
     * @return OptionInterface
     * @throws FailedSetOptionNameException
     */
    public function setName(string $name): OptionInterface;

    public function getName(): string;

    /**
     * @param mixed $value
     * @return OptionInterface
     * @throws FailedSetOptionValueException
     */
    public function setValue(mixed $value): OptionInterface;

    public function getValue(): mixed;

    public function isNullOption(): bool;
}
