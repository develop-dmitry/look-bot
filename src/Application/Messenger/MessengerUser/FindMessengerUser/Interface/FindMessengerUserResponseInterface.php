<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface;

use Look\Domain\MessengerUser\Interface\MessengerUserInterface;

interface FindMessengerUserResponseInterface
{
    public function isFound(): bool;

    public function getError(): string;

    public function getMessengerUser(): ?MessengerUserInterface;
}
