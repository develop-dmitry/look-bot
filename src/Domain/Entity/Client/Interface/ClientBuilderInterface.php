<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Client\Interface;

use Look\Domain\Value\Exception\InvalidValueException;

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
     * @throws InvalidValueException
     */
    public function make(): ClientInterface;

    /**
     * @return void
     */
    public function reset(): void;
}
