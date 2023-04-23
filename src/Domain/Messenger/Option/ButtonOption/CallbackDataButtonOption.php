<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option\ButtonOption;

use Look\Domain\Messenger\Exception\FailedSetOptionValueException;
use Look\Domain\Messenger\Interface\OptionInterface;

class CallbackDataButtonOption extends ButtonOption
{
    public function setValue(mixed $value): OptionInterface
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
