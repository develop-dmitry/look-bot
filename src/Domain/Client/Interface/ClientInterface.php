<?php

declare(strict_types=1);

namespace Look\Domain\Client\Interface;

use Look\Domain\Exception\RepositoryException;
use Look\Domain\MessengerUser\Exception\MessengerUserNotFoundException;
use Look\Domain\MessengerUser\Interface\MessengerUserInterface;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Id\Id;
use Look\Domain\Value\Id\Interface\IdInterface;
use Look\Domain\Value\Id\Interface\UseIdInterface;

interface ClientInterface extends UseIdInterface
{
    /**
     * @param IdInterface|null $telegramId
     * @return self
     * @throws InvalidValueException
     */
    public function setTelegramId(?IdInterface $telegramId): self;

    /**
     * @param IdInterface|null $userId
     * @return self
     * @throws InvalidValueException
     */
    public function setUserId(?IdInterface $userId): self;

    /**
     * @return Id|null
     */
    public function getTelegramId(): ?Id;

    /**
     * @return Id|null
     */
    public function getUserId(): ?Id;
}
