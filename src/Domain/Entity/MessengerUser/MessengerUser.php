<?php

declare(strict_types=1);

namespace Look\Domain\Entity\MessengerUser;

use Look\Domain\Entity\MessengerUser\Interface\MessengerUserInterface;
use Look\Domain\Messenger\Handler\MessengerHandlerName;
use Look\Domain\Property\UseId\HasId;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class MessengerUser implements MessengerUserInterface
{
    use HasId;

    protected ?MessengerHandlerName $messengerHandler = null;

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function setMessengerHandler(?string $handler): static
    {
        if ($handler) {
            $messengerHandler = MessengerHandlerName::tryFrom($handler);
        } else {
            $messengerHandler = null;
        }

        $this->messengerHandler = $messengerHandler;

        return $this;
    }

    public function getMessageHandler(): ?MessengerHandlerName
    {
        return $this->messengerHandler;
    }
}
