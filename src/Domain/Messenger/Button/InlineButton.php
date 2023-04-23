<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Button;

class InlineButton extends AbstractButton
{
    public function getType(): ButtonType
    {
        return ButtonType::Inline;
    }
}
