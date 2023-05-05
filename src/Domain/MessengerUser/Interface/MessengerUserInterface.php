<?php

declare(strict_types=1);

namespace Look\Domain\MessengerUser\Interface;

use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Id\Interface\UseIdInterface;

interface MessengerUserInterface extends UseIdInterface
{
    /**
     * @param MessengerHandlerName|null $messengerHandler
     * @return static
     */
    public function setMessengerHandler(?MessengerHandlerName $messengerHandler): static;

    /**
     * @return MessengerHandlerName|null
     */
    public function getMessageHandler(): ?MessengerHandlerName;
}
