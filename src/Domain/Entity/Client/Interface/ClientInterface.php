<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Client\Interface;

use Look\Domain\Entity\Exception\RepositoryException;
use Look\Domain\Entity\MessengerUser\Exception\MessengerUserNotFoundException;
use Look\Domain\Entity\MessengerUser\Interface\MessengerUserInterface;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Id;

interface ClientInterface
{
    /**
     * @param int|null $id
     * @return self
     * @throws InvalidValueException
     */
    public function setId(?int $id): self;

    /**
     * @param int|null $telegramId
     * @return self
     * @throws InvalidValueException
     */
    public function setTelegramId(?int $telegramId): self;

    /**
     * @param int|null $userId
     * @return self
     * @throws InvalidValueException
     */
    public function setUserId(?int $userId): self;

    /**
     * @return Id|null
     */
    public function getTelegramId(): ?Id;

    /**
     * @return Id|null
     */
    public function getUserId(): ?Id;

    /**
     * @return Id|null
     */
    public function getId(): ?Id;

    /**
     * @return MessengerUserInterface
     * @throws RepositoryException|InvalidValueException|MessengerUserNotFoundException
     */
    public function getTelegramUser(): MessengerUserInterface;
}
