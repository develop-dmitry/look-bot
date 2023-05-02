<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository;

use Illuminate\Support\Facades\Redis;
use Look\Domain\Entity\Client\Client;
use Look\Domain\Messenger\Exception\FailedSetNextMessageHandlerException;
use Look\Domain\Messenger\Exception\NextMessageHandlerNotFoundException;
use Look\Domain\Messenger\Handler\MessengerHandlerName;
use Look\Domain\Messenger\Interface\NextMessageHandlerRepositoryInterface;
use Look\Domain\Repository\Interface\Parameter\ParameterFactoryInterface;
use Look\Domain\Storage\Exception\StorageException;
use Look\Domain\Storage\Interface\Request\RequestFactoryInterface;
use Look\Domain\Storage\Interface\StorageInterface;
use RedisException;

class NextMessageHandlerRepository implements NextMessageHandlerRepositoryInterface
{
    public function __construct(
        protected StorageInterface $storage,
        protected ParameterFactoryInterface $parameterFactory,
        protected RequestFactoryInterface $requestFactory
    ) {
    }

    public function getHandlerName(Client $client): MessengerHandlerName
    {
        $clientId = $client->getId()?->getValue();

        $filter = $this->parameterFactory->makeFilter()
            ->addCondition('id', '', $clientId)
            ->addCondition('next_message_handler', '', '');

        $selectRequest = $this->requestFactory->makeSelectRequest($filter);
        $fields = $this->storage->select($selectRequest);

        $handlerName = MessengerHandlerName::tryFrom($fields['next_message_handler'] ?? '');

        if (!$handlerName) {
            throw new NextMessageHandlerNotFoundException(
                "Next message handler for client $clientId not found"
            );
        }

        return $handlerName;
    }

    public function setHandlerName(Client $client, MessengerHandlerName $name): void
    {
        $insertRequest = $this->requestFactory->makeInsertRequest([
            'id' => $client->getId()?->getValue(),
            'next_message_handler' => $name->value]
        );

        $this->storage->insert($insertRequest);
    }

    public function deleteHandlerName(Client $client): void
    {
        $filter = $this->parameterFactory->makeFilter()
            ->addCondition('id', '=', $client->getId()?->getValue())
            ->addCondition('next_message_handler', '', 'next_message_handler');

        $deleteRequest = $this->requestFactory->makeDeleteRequest($filter);

        $this->storage->delete($deleteRequest);
    }
}
