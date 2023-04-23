<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Option\ButtonOption;

use Look\Domain\Messenger\Option\AbstractNullOption;

class NullButtonOption extends AbstractNullOption
{
    public function __construct()
    {
        parent::__construct(ButtonOptionName::Null->value, null);
    }
}
