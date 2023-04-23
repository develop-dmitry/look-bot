<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option\KeyboardOption;

use Look\Domain\Messenger\Option\AbstractNullOption;

class NullKeyboardOption extends AbstractNullOption
{
    public function __construct()
    {
        parent::__construct(KeyboardOptionName::Null->value, null);
    }
}
