<?php

declare(strict_types=1);

namespace Look\Domain\Client\Interface;

use Look\Domain\Client\Exception\ClientNotFoundException;
use Look\Domain\Client\Exception\FailedCreateClientException;

interface ClientRepositoryInterface
{
    /**
     * @param int $telegramId
     * @return ClientInterface
     * @throws ClientNotFoundException
     */
    public function getClientByTelegramId(int $telegramId): ClientInterface;

    /**
     * @param ClientInterface $client
     * @return void
     * @throws FailedCreateClientException
     */
    public function createClient(ClientInterface $client): void;
}
