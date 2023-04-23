<?php

declare(strict_types=1);

namespace Look\Domain\Messenger\Interface;

use Look\Domain\Messenger\Exception\MessengerHandlerAlreadyExistsException;
use Look\Domain\Messenger\Exception\MessengerHandlerNotFoundException;
use Look\Domain\Messenger\Handler\MessengerHandlerName;
use Look\Domain\Messenger\Handler\MessengerHandlerType;

interface MessengerHandlerContainerInterface
{
    /**
     * @param MessengerHandlerInterface $handler
     * @param MessengerHandlerName $name
     * @param MessengerHandlerType $type
     * @return void
     * @throws MessengerHandlerAlreadyExistsException
     */
    public function addHandler(
        MessengerHandlerName $name,
        MessengerHandlerType $type,
        MessengerHandlerInterface $handler
    ): void;

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
