<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Entity\Client\Client;
use Look\Domain\Messenger\Exception\FailedSetNextMessageHandlerException;
use Look\Domain\Messenger\Exception\NextMessageHandlerNotFoundException;
use Look\Domain\Messenger\Handler\MessengerHandlerName;
use Look\Domain\Storage\Exception\StorageException;

interface NextMessageHandlerRepositoryInterface
{
    /**
     * @param Client $client
     * @return MessengerHandlerName
     * @throws NextMessageHandlerNotFoundException|StorageException
     */
    public function getHandlerName(Client $client): MessengerHandlerName;

    /**
     * @param Client $client
     * @param MessengerHandlerName $name
     * @return void
     * @throws StorageException
     */
    public function setHandlerName(Client $client, MessengerHandlerName $name): void;

    /**
     * @param Client $client
     * @return void
     * @throws StorageException
     */
    public function deleteHandlerName(Client $client): void;
}
