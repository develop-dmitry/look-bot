<?php

declare(strict_types=1);

namespace Look\Application\Messenger\MessengerUser\SaveMessengerUser\Interface;

interface SaveMessengerUserInterface
{
    /**
     * @param SaveMessengerUserRequestInterface $request
     * @return SaveMessengerUserResponseInterface
     */
    public function saveMessengerUser(SaveMessengerUserRequestInterface $request): SaveMessengerUserResponseInterface;
}
