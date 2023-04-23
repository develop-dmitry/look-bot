<?php

declare(strict_types=1);

namespace Look\Domain\Client\Entity;

use Look\Domain\Client\Interface\ClientInterface;

class Client implements ClientInterface
{
    protected ?int $id = null;

    protected ?int $telegramId = null;

    protected ?int $userId = null;

    public function setId(?int $id): ClientInterface
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTelegramId(?int $telegramId): ClientInterface
    {
        $this->telegramId = $telegramId;
        return $this;
    }

    public function setUserId(?int $userId): ClientInterface
    {
        $this->userId = $userId;
        return $this;
    }

    public function getTelegramId(): ?int
    {
        return $this->telegramId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }
}
