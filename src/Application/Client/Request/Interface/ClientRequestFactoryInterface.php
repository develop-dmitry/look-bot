<?php

declare(strict_types=1);

namespace Look\Application\Client\Request\Interface;

interface ClientRequestFactoryInterface
{
    public function makeClientByTelegramRequest(int $telegram): ClientByTelegramRequestInterface;
}
