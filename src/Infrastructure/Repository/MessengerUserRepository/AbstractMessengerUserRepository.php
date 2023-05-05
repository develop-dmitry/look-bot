<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository\MessengerUserRepository;

use Look\Application\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Exception\RepositoryException;
use Look\Domain\MessengerUser\Interface\MessengerUserBuilderInterface;
use Look\Domain\MessengerUser\Interface\MessengerUserInterface;
use Look\Domain\MessengerUser\Interface\MessengerUserRepositoryInterface;
use Look\Domain\Value\Exception\InvalidValueException;
use Predis\Client;
use Psr\Log\LoggerInterface;

abstract class AbstractMessengerUserRepository implements MessengerUserRepositoryInterface
{
    protected Client $client;

    protected string $messengerCode = '';

    public function __construct(
        protected MessengerUserBuilderInterface $messengerUserBuilder,
        protected LoggerInterface $logger
    ) {
        $this->client = \Illuminate\Support\Facades\Redis::client();
    }

    public function getMessengerUserById(int $id): MessengerUserInterface
    {
        $data = ['id' => $id];

        $keys = $this->getKeys($this->getKey($id, '*'));
        if (!empty($keys)) {
            foreach ($keys as $key) {
                $data[$this->getFieldFromKey($key)] = $this->client->get($key);
            }
        }

        return $this->makeEntity($data);
    }

    public function saveMessengerUser(MessengerUserInterface $messengerUser): bool
    {
        $id = $messengerUser->getId()->getValue();
        $data = $this->makeArray($messengerUser);

        foreach ($data as $key => $value) {
            $this->client->set($this->getKey($id, $key), $value);
        }

        return true;
    }

    protected function getFieldFromKey(string $key): string
    {
        $split = explode(':', $key);

        if (count($split) >= 3) {
            return $split[2];
        }

        return '';
    }

    /**
     * @param string $pattern
     * @return string[]
     */
    protected function getKeys(string $pattern): array
    {
        $keys = $this->client->keys($pattern);

        return array_map(static fn ($key) => str_replace('laravel_database_', '', $key), $keys);
    }

    protected function getKey(int $id, string $field): string
    {
        return "$this->messengerCode:$id:$field";
    }

    /**
     * @throws RepositoryException
     */
    protected function makeEntity(array $data): MessengerUserInterface
    {
        try {
            return $this->messengerUserBuilder
                ->setId($data['id'])
                ->setMessengerHandler($data['messenger_handler'] ?? null)
                ->make();
        } catch (InvalidValueException|NoRequiredPropertiesException $exception) {
            $this->logger->emergency('Не удалось создать сущность из модели', [
                'exception' => $exception,
                'data' => $data
            ]);

            throw new RepositoryException($exception->getMessage());
        }
    }

    protected function makeArray(MessengerUserInterface $messengerUser): array
    {
        return [
            'messenger_handler' => $messengerUser->getMessageHandler()?->value
        ];
    }
}
