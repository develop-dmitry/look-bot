<?php

declare(strict_types=1);

namespace Look\Application\Client\Request;

use Look\Application\Client\Request\Interface\ClientByTelegramRequestInterface;

class ClientByTelegramRequest implements ClientByTelegramRequestInterface
{
    public function __construct(
        protected int $telegram
    ) {
    }

    public function getTelegram(): int
    {
        return $this->telegram;
    }
}
