<?php

declare(strict_types=1);

namespace Look\Domain\Client\Interface;

interface ClientInterface
{
    /**
     * @param int|null $id
     * @return self
     */
    public function setId(?int $id): self;

    /**
     * @param int|null $telegramId
     * @return self
     */
    public function setTelegramId(?int $telegramId): self;

    /**
     * @param int|null $userId
     * @return self
     */
    public function setUserId(?int $userId): self;

    /**
     * @return int|null
     */
    public function getTelegramId(): ?int;

    /**
     * @return int|null
     */
    public function getUserId(): ?int;

    /**
     * @return int|null
     */
    public function getId(): ?int;
}
