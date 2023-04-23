<?php

declare(strict_types=1);

namespace Look\Domain\Client\Entity;

use Look\Domain\Client\Interface\ClientBuilderInterface;
use Look\Domain\Client\Interface\ClientInterface;

class ClientBuilder implements ClientBuilderInterface
{
    protected ?int $id = null;

    protected ?int $telegramId = null;

    protected ?int $userId = null;

    public function setId(?int $id): ClientBuilderInterface
    {
        $this->id = $id;
        return $this;
    }

    public function setTelegramId(?int $telegramId): ClientBuilderInterface
    {
        $this->telegramId = $telegramId;
        return $this;
    }

    public function setUserId(?int $userId): ClientBuilderInterface
    {
        $this->userId = $userId;
        return $this;
    }

    public function makeClient(): ClientInterface
    {
        $client = new Client();

        $client
            ->setId($this->id)
            ->setUserId($this->userId)
            ->setTelegramId($this->telegramId);

        $this->reset();

        return $client;
    }

    public function reset(): void
    {
        $this->id = null;
        $this->telegramId = null;
        $this->userId = null;
    }
}
