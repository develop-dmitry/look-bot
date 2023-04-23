<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option\KeyboardOption;

use Look\Domain\Messenger\Exception\FailedSetOptionNameException;
use Look\Domain\Messenger\Interface\OptionInterface;
use Look\Domain\Messenger\Option\AbstractOption;

class KeyboardOption extends AbstractOption
{
    public function __construct()
    {
        parent::__construct(KeyboardOptionName::Null->value, null);
    }

    public function setName(string $name): OptionInterface
    {
        if (!KeyboardOptionName::tryFrom($name)) {
            throw new FailedSetOptionNameException("Failed to set name $name for reply keyboard option");
        }

        return parent::setName($name);
    }
}
