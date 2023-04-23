<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Button;

class ReplyButton extends AbstractButton
{
    public function getType(): ButtonType
    {
        return ButtonType::Reply;
    }
}
