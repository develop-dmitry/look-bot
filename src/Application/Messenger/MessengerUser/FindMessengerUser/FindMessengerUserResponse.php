<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\FindMessengerUser;

use Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface\FindMessengerUserResponseInterface;
use Look\Domain\MessengerUser\Interface\MessengerUserInterface;

class FindMessengerUserResponse implements FindMessengerUserResponseInterface
{
    public function __construct(
        protected bool $found,
        protected string $error,
        protected ?MessengerUserInterface $messengerUser = null
    ) {
    }

    public function isFound(): bool
    {
        return $this->found;
    }

    public function getError(): string
    {
        return $this->error;
    }

    public function getMessengerUser(): ?MessengerUserInterface
    {
        return $this->messengerUser;
    }
}
