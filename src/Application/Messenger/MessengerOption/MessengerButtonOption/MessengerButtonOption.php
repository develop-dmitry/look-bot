<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption\MessengerButtonOption;

use Look\Application\Messenger\MessengerOption\AbstractMessengerOption;
use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionNameException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;

class MessengerButtonOption extends AbstractMessengerOption
{
    public function __construct()
    {
        parent::__construct(MessengerButtonOptionName::Null->value, null);
    }

    public function setName(string $name): MessengerOptionInterface
    {
        if (!MessengerButtonOptionName::tryFrom($name)) {
            throw new FailedSetOptionNameException("Failed to set name $name for button option");
        }

        return parent::setName($name);
    }
}
