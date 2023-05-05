<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\FindMessengerUser\Interface;

interface FindMessengerUserInterface
{
    public function findMessengerUser(FindMessengerUserRequestInterface $request): FindMessengerUserResponseInterface;
}
