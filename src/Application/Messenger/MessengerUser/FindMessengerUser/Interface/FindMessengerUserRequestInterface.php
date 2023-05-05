<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface;

interface FindMessengerUserRequestInterface
{
    /**
     * @return int
     */
    public function getMessengerUserUid(): int;
}
