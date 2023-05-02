<?php

declare(strict_types=1);

namespace Look\Application\Client;

use Look\Application\Client\Request\ClientByTelegramRequest;
use Look\Domain\Entity\Client\Client;
use Look\Domain\Entity\Client\Exception\ClientNotFoundException;
use Look\Domain\Storage\Exception\StorageException;
use Look\Domain\Value\Exception\InvalidValueException;

interface ClientUseCaseInterface
{
    /**
     * @param ClientByTelegramRequest $request
     * @return Client
     * @throws StorageException|ClientNotFoundException|InvalidValueException
     */
    public function getClientByTelegram(ClientByTelegramRequest $request): Client;
}
