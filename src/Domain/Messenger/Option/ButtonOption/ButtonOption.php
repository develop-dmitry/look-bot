<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option\ButtonOption;

use Look\Domain\Messenger\Exception\FailedSetOptionNameException;
use Look\Domain\Messenger\Interface\OptionInterface;
use Look\Domain\Messenger\Option\AbstractOption;

class ButtonOption extends AbstractOption
{
    public function __construct()
    {
        parent::__construct(ButtonOptionName::Null->value, null);
    }

    public function setName(string $name): OptionInterface
    {
        if (!ButtonOptionName::tryFrom($name)) {
            throw new FailedSetOptionNameException("Failed to set name $name for button option");
        }

        return parent::setName($name);
    }
}
