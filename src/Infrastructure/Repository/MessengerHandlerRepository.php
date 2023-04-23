<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository;

use Illuminate\Support\Facades\Redis;
use Look\Domain\Client\Entity\Client;
use Look\Domain\Messenger\Exception\FailedSetNextMessageHandlerException;
use Look\Domain\Messenger\Exception\NextMessengerHandlerNotFoundException;
use Look\Domain\Messenger\Handler\MessengerHandlerName;
use Look\Domain\Messenger\Interface\MessageHandlerRepositoryInterface;
use RedisException;

class MessengerHandlerRepository implements MessageHandlerRepositoryInterface
{
    protected string $nextHandlerNamePattern = 'client:%CLIENT_ID%:next_message_handler';

    public function getNextHandlerName(Client $client): MessengerHandlerName
    {
        $handlerName = null;
        $key = $this->getKey($client, $this->nextHandlerNamePattern);

        if (Redis::exists($key)) {
            $handlerName = MessengerHandlerName::tryFrom(Redis::get($key));
        }

        if ($handlerName) {
            return $handlerName;
        }

        throw new NextMessengerHandlerNotFoundException(
            "Next message handler for client {$client->getId()} not found"
        );
    }

    public function setNextHandlerName(Client $client, MessengerHandlerName $name): void
    {
        $key = $this->getKey($client, $this->nextHandlerNamePattern);

        try {
            Redis::set($key, $name->value);
        } catch (RedisException $exception) {
            throw new FailedSetNextMessageHandlerException($exception->getMessage());
        }
    }

    protected function getKey(Client $client, string $pattern): string
    {
        return str_replace(['%CLIENT_ID%'], [$client->getId()], $pattern);
    }
}
