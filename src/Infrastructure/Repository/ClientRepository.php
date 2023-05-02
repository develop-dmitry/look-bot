<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository;

use Look\Domain\Entity\Client\Exception\ClientNotFoundException;
use Look\Domain\Entity\Client\Interface\ClientInterface;
use Look\Domain\Entity\Client\Interface\ClientRepositoryInterface;
use Look\Domain\Storage\Interface\Request\InsertRequestInterface;

class ClientRepository extends AbstractRepository implements ClientRepositoryInterface
{
    public function getClientByTelegramId(int $telegramId): ClientInterface
    {
        $filter = $this->parameterFactory->makeFilter()
            ->addCondition('telegram_id', '=', $telegramId);

        $selectRequest = $this->requestFactory->makeSelectRequest($filter);
        $clients = $this->storage->select($selectRequest);

        if (empty($clients)) {
            throw new ClientNotFoundException("Client with telegram id $telegramId not found");
        }

        return $clients[0];
    }

    public function createClient(ClientInterface $client): void
    {
        $insertRequest = $this->makeInsertRequest($client);

        $id = $this->storage->insert($insertRequest);

        $client->setId($id);
    }

    protected function makeInsertRequest(ClientInterface $client): InsertRequestInterface
    {
        $properties = [
            'telegram_id' => $client->getTelegramId()?->getValue(),
            'user_id' => $client->getUserId()?->getValue()
        ];

        return $this->requestFactory->makeInsertRequest($properties);
    }
}
