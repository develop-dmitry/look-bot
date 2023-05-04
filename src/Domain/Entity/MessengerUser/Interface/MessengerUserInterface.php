<?php

declare(strict_types=1);

namespace Look\Domain\Entity\MessengerUser\Interface;

use Look\Domain\Messenger\Handler\MessengerHandlerName;
use Look\Domain\Property\UseId\UseIdInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface MessengerUserInterface extends UseIdInterface
{
    /**
     * @param string $handler
     * @return static
     * @throws InvalidValueException
     */
    public function setMessengerHandler(string $handler): static;

    /**
     * @return MessengerHandlerName|null
     */
    public function getMessageHandler(): ?MessengerHandlerName;
}
