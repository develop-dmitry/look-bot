<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerHandler\Interface;

use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerType;
use Look\Application\Messenger\MessengerHandler\Exception\MessengerHandlerAlreadyExistsException;
use Look\Application\Messenger\MessengerHandler\Exception\MessengerHandlerNotFoundException;

interface MessengerHandlerContainerInterface
{
    /**
     * @param MessengerHandlerInterface $handler
     * @return void
     * @throws MessengerHandlerAlreadyExistsException
     */
    public function addHandler(MessengerHandlerInterface $handler): void;

    /**
     * @param MessengerHandlerName $name
     * @param MessengerHandlerType $type
     * @return MessengerHandlerInterface
     * @throws MessengerHandlerNotFoundException
     */
    public function getHandler(MessengerHandlerName $name, MessengerHandlerType $type): MessengerHandlerInterface;

    /**
     * @return MessengerHandlerInterface[]
     */
    public function getHandlers(MessengerHandlerType $type): array;

    /**
     * @param MessengerHandlerName $name
     * @param MessengerHandlerType $type
     * @return bool
     */
    public function hasHandler(MessengerHandlerName $name, MessengerHandlerType $type): bool;
}
