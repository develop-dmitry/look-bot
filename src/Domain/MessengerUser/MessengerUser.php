<?php

declare(strict_types=1);

namespace Look\Domain\MessengerUser;

use Look\Application\Messenger\MessengerHandler\Enum\MessengerHandlerName;
use Look\Domain\MessengerUser\Interface\MessengerUserInterface;
use Look\Domain\Value\Factory\ValueFactoryInterface;
use Look\Domain\Value\Id\Trait\HasId;

class MessengerUser implements MessengerUserInterface
{
    use HasId;

    protected ?MessengerHandlerName $messageHandler = null;

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function setMessageHandler(?MessengerHandlerName $messengerHandler): static
    {
        $this->messageHandler = $messengerHandler;
        return $this;
    }

    public function getMessageHandler(): ?MessengerHandlerName
    {
        return $this->messageHandler;
    }
}
