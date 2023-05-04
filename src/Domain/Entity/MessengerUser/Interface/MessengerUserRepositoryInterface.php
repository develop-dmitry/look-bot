<?php

declare(strict_types=1);

namespace Look\Domain\Entity\MessengerUser\Interface;

use Look\Domain\Entity\Exception\RepositoryException;
use Look\Domain\Entity\MessengerUser\Exception\MessengerUserNotFoundException;
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
