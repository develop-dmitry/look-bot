<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository\ClothesRepository;

use App\Models\Clothes;
use Look\Application\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Client\Interface\ClientInterface;
use Look\Domain\Clothes\Exception\ClothesRepositoryException;
use Look\Domain\Clothes\Exception\ClothesNotFoundException;
use Look\Domain\Clothes\Interface\ClothesBuilderInterface;
use Look\Domain\Clothes\Interface\ClothesInterface;
use Look\Domain\Clothes\Interface\ClothesPaginationInterface;
use Look\Domain\Clothes\Interface\ClothesRepositoryInterface;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Id\Id;
use Psr\Log\LoggerInterface;

class EloquentClothesRepository implements ClothesRepositoryInterface
{
    public function __construct(
        protected ClothesBuilderInterface $clothesBuilder,
        protected LoggerInterface $logger
    ) {
    }

    public function getClothesForUser(
        ClientInterface $client,
        int $perPage = 10,
        int $page = 1
    ): ClothesPaginationInterface {
        $result = [];
        $clothes = Clothes::orderBy('id', 'desc')->paginate($perPage, ['*'] , 'page', $page);

        foreach ($clothes->items() as $item) {
            try {
                $entity = $this->makeEntity($item);
                $entity->setChosen($item->clients->contains($client->getId()->getValue()));

                $result[] = $entity;
            } catch (NoRequiredPropertiesException|InvalidValueException $exception) {
                $this->logger->emergency('Не удалось создать сущность одежды', [
                    'model' => $item,
                    'exception' => $exception
                ]);
            }
        }

        return new ClothesPagination($result, $clothes->currentPage(), $clothes->lastPage());
    }

    public function getClothes(int $clothesId): ClothesInterface
    {
        $model = Clothes::find($clothesId);

        if (!$model) {
            throw new ClothesNotFoundException("Clothes with id {$clothesId} not found");
        }

        return $this->makeEntity($model);
    }

    public function chooseClothes(ClientInterface $client, ClothesInterface $clothes): void
    {
        $clothesId = $clothes->getId();
        $clientId = $client->getId();

        iF (!$clothesId || !$clientId) {
            throw new ClothesRepositoryException('Clothes id or client id is null');
        }

        $model = Clothes::find($clothesId->getValue());

        if (!$model) {
            throw new ClothesNotFoundException("Clothes with id {$clothesId->getValue()} not found");
        }

        $model->clients()->syncWithoutDetaching([$clientId->getValue()]);
    }

    /**
     * @throws ClothesRepositoryException
     */
    public function makeEntity(Clothes $clothes): ClothesInterface
    {
        try {
            return $this->clothesBuilder
                ->setId($clothes->id)
                ->setName($clothes->name)
                ->setPhoto(\Storage::disk('local')->url($clothes->photo))
                ->make();
        } catch (InvalidValueException|NoRequiredPropertiesException $exception) {
            throw new ClothesRepositoryException($exception->getMessage());
        }
    }
}
