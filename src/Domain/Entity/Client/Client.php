<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Client;

use Look\Domain\Entity\Client\Interface\ClientInterface;
use Look\Domain\Value\Id;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class Client implements ClientInterface
{
    protected ?Id $id = null;

    protected ?Id $telegramId = null;

    protected ?Id $userId = null;

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function setId(?int $id): ClientInterface
    {
        $this->id = ($id) ? $this->valueFactory->makeId($id) : null;
        return $this;
    }

    public function getId(): ?Id
    {
        return $this->id;
    }

    public function setTelegramId(?int $telegramId): ClientInterface
    {
        $this->telegramId = ($telegramId) ? $this->valueFactory->makeId($telegramId) : null;
        return $this;
    }

    public function setUserId(?int $userId): ClientInterface
    {
        $this->userId = ($userId) ? $this->valueFactory->makeId($userId) : null;
        return $this;
    }

    public function getTelegramId(): ?Id
    {
        return $this->telegramId;
    }

    public function getUserId(): ?Id
    {
        return $this->userId;
    }
}
