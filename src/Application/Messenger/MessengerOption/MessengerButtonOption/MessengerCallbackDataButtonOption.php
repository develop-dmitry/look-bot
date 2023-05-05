<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerOption\MessengerButtonOption;

use Look\Application\Messenger\MessengerOption\Exception\FailedSetOptionValueException;
use Look\Application\Messenger\MessengerOption\Interface\MessengerOptionInterface;

class MessengerCallbackDataButtonOption extends MessengerButtonOption
{
    public function setValue(mixed $value): MessengerOptionInterface
    {
        if (!is_array($value) || !isset($value['action'])) {
            throw new FailedSetOptionValueException('Callback data must be array and contains action');
        }

        return parent::setValue($value);
    }

    public function getValue(): string
    {
        $value = json_encode($this->value);

        return ($value) ?: '';
    }
}
