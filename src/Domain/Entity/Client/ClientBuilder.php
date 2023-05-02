<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Client;

use Look\Domain\Entity\Client\Interface\ClientBuilderInterface;
use Look\Domain\Entity\Client\Interface\ClientInterface;
use Look\Domain\Value\Interface\ValueFactoryInterface;

class ClientBuilder implements ClientBuilderInterface
{
    protected ?int $id = null;

    protected ?int $telegramId = null;

    protected ?int $userId = null;

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

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

    public function make(): ClientInterface
    {
        $client = new Client($this->valueFactory);

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
