<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository;

use App\Models\Client;
use Look\Domain\Client\Exception\ClientNotFoundException;
use Look\Domain\Client\Exception\FailedCreateClientException;
use Look\Domain\Client\Interface\ClientBuilderInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\Client\Interface\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        protected ClientBuilderInterface $clientBuilder
    ) {
    }

    public function getClientByTelegramId(int $telegramId): ClientInterface
    {
        $client = Client::where('telegram_id', $telegramId)->first();

        if (!$client) {
            throw new ClientNotFoundException("Client with telegram id $telegramId not found");
        }

        return $this->makeEntity($client);
    }

    public function createClient(ClientInterface $client): void
    {
        $model = new Client();

        $model->user_id = $client->getUserId();
        $model->telegram_id = $client->getTelegramId();

        if (!$model->save()) {
            throw new FailedCreateClientException('Failed to create client');
        }

        $client->setId($model->id);
    }

    protected function makeEntity(Client $client): ClientInterface
    {
        return $this->clientBuilder
            ->setUserId($client->user_id)
            ->setTelegramId($client->telegram_id)
            ->makeClient();
    }
}
