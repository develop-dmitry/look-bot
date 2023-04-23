<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Client\Entity\Client;
use Look\Domain\Messenger\Exception\FailedSetNextMessageHandlerException;
use Look\Domain\Messenger\Exception\NextMessengerHandlerNotFoundException;
use Look\Domain\Messenger\Handler\MessengerHandlerName;

interface MessageHandlerRepositoryInterface
{
    /**
     * @param Client $client
     * @return MessengerHandlerName
     * @throws NextMessengerHandlerNotFoundException
     */
    public function getNextHandlerName(Client $client): MessengerHandlerName;

    /**
     * @param Client $client
     * @param MessengerHandlerName $name
     * @return void
     * @throws FailedSetNextMessageHandlerException
     */
    public function setNextHandlerName(Client $client, MessengerHandlerName $name): void;
}
