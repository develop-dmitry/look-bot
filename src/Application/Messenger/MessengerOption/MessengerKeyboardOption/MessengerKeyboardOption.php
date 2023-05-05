<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption\MessengerKeyboardOption;

use Look\Application\Messenger\MessengerOption\AbstractMessengerOption;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionNameException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;

class MessengerKeyboardOption extends AbstractMessengerOption
{
    public function __construct()
    {
        parent::__construct(MessengerKeyboardOptionName::Null->value, null);
    }

    public function setName(string $name): MessengerOptionInterface
    {
        if (!MessengerKeyboardOptionName::tryFrom($name)) {
            throw new FailedSetOptionNameException("Failed to set name $name for reply keyboard option");
        }

        return parent::setName($name);
    }
}
