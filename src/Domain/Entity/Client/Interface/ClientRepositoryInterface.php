<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Client\Interface;

use Look\Domain\Entity\Client\Exception\ClientNotFoundException;
use Look\Domain\Storage\Exception\StorageException;
use Look\Domain\Value\Exception\InvalidValueException;

interface ClientRepositoryInterface
{
    /**
     * @param int $telegramId
     * @return ClientInterface
     * @throws ClientNotFoundException|StorageException
     */
    public function getClientByTelegramId(int $telegramId): ClientInterface;

    /**
     * @param ClientInterface $client
     * @return void
     * @throws StorageException|InvalidValueException
     */
    public function createClient(ClientInterface $client): void;

    /**
     * @param array $ids
     * @return ClientInterface[]
     * @throws StorageException
     */
    public function getItemsById(array $ids): array;
}
