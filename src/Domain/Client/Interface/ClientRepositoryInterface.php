<?php

declare(strict_types=1);

namespace Look\Domain\Client\Interface;

use Look\Domain\Client\Exception\ClientNotFoundException;
use Look\Domain\Exception\RepositoryException;

interface ClientRepositoryInterface
{
    /**
     * @param int $telegramId
     * @return ClientInterface
     * @throws ClientNotFoundException|RepositoryException
     */
    public function getClientByTelegramId(int $telegramId): ClientInterface;

    /**
     * @param ClientInterface $client
     * @return void
     * @throws RepositoryException
     */
    public function createClient(ClientInterface $client): void;

    /**
     * @param ClientInterface $client
     * @return void
     * @throws RepositoryException|ClientNotFoundException
     */
    public function saveClient(ClientInterface $client): void;
}
