<?php

declare(strict_types=1);

namespace Look\Domain\Client\Interface;

interface ClientBuilderInterface
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
     * @return ClientInterface
     */
    public function makeClient(): ClientInterface;

    /**
     * @return void
     */
    public function reset(): void;
}
