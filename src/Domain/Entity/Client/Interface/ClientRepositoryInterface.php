<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Client\Interface;

use Look\Domain\Entity\Client\Exception\ClientNotFoundException;
use Look\Domain\Entity\Exception\RepositoryException;

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
}
