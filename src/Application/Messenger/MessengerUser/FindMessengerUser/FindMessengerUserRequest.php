<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\FindMessengerUser;

use Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface\FindMessengerUserRequestInterface;

class FindMessengerUserRequest implements FindMessengerUserRequestInterface
{
    public function __construct(
        protected int $uid
    ) {
    }

    public function getMessengerUserUid(): int
    {
        return $this->uid;
    }
}
