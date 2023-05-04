<?php

declare(strict_types=1);

namespace Look\Application\Client\Request;

use Look\Application\Client\Request\Interface\ClientByTelegramRequestInterface;
use Look\Application\Client\Request\Interface\ClientRequestFactoryInterface;

class ClientRequestFactory implements ClientRequestFactoryInterface
{
    public function makeClientByTelegramRequest(int $telegram): ClientByTelegramRequestInterface
    {
        return new ClientByTelegramRequest($telegram);
    }
}
