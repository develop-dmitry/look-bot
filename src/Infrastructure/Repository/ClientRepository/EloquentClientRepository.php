<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository\ClientRepository;

use App\Models\Client;
use Look\Application\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Client\Exception\ClientNotFoundException;
use Look\Domain\Client\Interface\ClientBuilderInterface;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\Client\Interface\ClientRepositoryInterface;
use Look\Domain\Exception\RepositoryException;
use Look\Domain\GeoLocation\Interface\GeoLocationBuilderInterface;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Factory\ValueFactoryInterface;
use Psr\Log\LoggerInterface;

class EloquentClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        protected ClientBuilderInterface $clientBuilder,
        protected GeoLocationBuilderInterface $geoLocationBuilder,
        protected ValueFactoryInterface $valueFactory,
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

        try {
            $client->setId($this->valueFactory->makeId($clientModel->id));
        } catch (InvalidValueException $exception) {
            $this->logger->emergency('Не удалось создать объект ID', [
                'id' => $clientModel->id,
                'exception' => $exception
            ]);

            throw new RepositoryException('Fail to make ID');
        }
    }

    public function saveClient(ClientInterface $client): void
    {
        $clientModel = Client::find($client->getId()->getValue());

        if (!$clientModel) {
            throw new ClientNotFoundException("Client with id {$client->getId()->getValue()} not found");
        }

        $this->fillModel($client, $clientModel);

        if (!$clientModel->save()) {
            throw new RepositoryException('Failed to save client');
        }
    }

    /**
     * @throws RepositoryException
     */
    protected function makeEntity(Client $client): ClientInterface
    {
        try {
            $geoLocation = null;

            if ($client->lat && $client->lon) {
                $geoLocation = $this->geoLocationBuilder
                    ->setLon($client->lon)
                    ->setLat($client->lat)
                    ->make();
            }

            return $this->clientBuilder
                ->fromArray($client->toArray())
                ->setGeoLocation($geoLocation)
                ->make();
        } catch (InvalidValueException|NoRequiredPropertiesException $exception) {
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
            'telegram_id' => $client->getTelegramId()?->getValue(),
            'lat' => $client->getGeoLocation()?->getLat()->getValue(),
            'lon' => $client->getGeoLocation()?->getLon()->getValue()
        ]);
    }
}
