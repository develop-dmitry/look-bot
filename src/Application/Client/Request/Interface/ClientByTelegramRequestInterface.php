<?php

namespace Look\Application\Client\Request\Interface;

interface ClientByTelegramRequestInterface
{
    /**
     * @return int
     */
    public function getTelegram(): int;
}
