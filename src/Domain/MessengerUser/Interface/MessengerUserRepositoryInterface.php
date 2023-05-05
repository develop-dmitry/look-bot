<?php

declare(strict_types=1);

namespace Look\Domain\MessengerUser\Interface;

use Look\Domain\Exception\RepositoryException;
use Look\Domain\MessengerUser\Exception\MessengerUserNotFoundException;
use Look\Domain\Value\Exception\InvalidValueException;

interface MessengerUserRepositoryInterface
{
    /**
     * @param int $id
     * @return MessengerUserInterface
     * @throws RepositoryException|InvalidValueException|MessengerUserNotFoundException
     */
    public function getMessengerUserById(int $id): MessengerUserInterface;

    /**
     * @param MessengerUserInterface $messengerUser
     * @return bool
     * @throws RepositoryException
     */
    public function saveMessengerUser(MessengerUserInterface $messengerUser): bool;
}
