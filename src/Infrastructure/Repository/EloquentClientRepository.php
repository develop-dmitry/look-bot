<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository;

use App\Models\Client;
use Look\Domain\Entity\Client\Exception\ClientNotFoundException;
use Look\Domain\Entity\Client\Interface\ClientBuilderInterface;
use Look\Domain\Entity\Client\Interface\ClientInterface;
use Look\Domain\Entity\Client\Interface\ClientRepositoryInterface;
use Look\Domain\Entity\Exception\RepositoryException;
use Look\Domain\Value\Exception\InvalidValueException;
use Psr\Log\LoggerInterface;

class EloquentClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        protected ClientBuilderInterface $clientBuilder,
        protected LoggerInterface $logger
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
        $clientModel = new Client();

        $this->fillModel($client, $clientModel);

        if (!$clientModel->save()) {
            $this->logger->emergency('Не удалось создать клиента', ['client' => $client]);
            throw new RepositoryException('Failed to create client');
        }

        $client->setId($clientModel->id);
    }

    /**
     * @throws RepositoryException
     */
    protected function makeEntity(Client $client): ClientInterface
    {
        try {
            return $this->clientBuilder
                ->fromArray($client->toArray())
                ->make();
        } catch (InvalidValueException $exception) {
            $this->logger->emergency('Не удалось создать сущность из модели', [
                'exception' => $exception,
                'model' => $client
            ]);

            throw new RepositoryException($exception->getMessage());
        }
    }

    protected function fillModel(ClientInterface $client, Client $clientModel): void
    {
        $clientModel->fill([
            'user_id' => $client->getUserId()?->getValue(),
            'telegram_id' => $client->getTelegramId()?->getValue()
        ]);
    }
}
