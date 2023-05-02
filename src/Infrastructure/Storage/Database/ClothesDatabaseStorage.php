<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Database;

use App\Models\Clothes;
use Illuminate\Database\Eloquent\Model;
use Look\Domain\Entity\Clothes\Interface\ClothesBuilderInterface;
use Look\Domain\Entity\Clothes\Interface\ClothesInterface;
use Psr\Log\LoggerInterface;

class ClothesDatabaseStorage extends AbstractDatabaseStorage
{
    protected string $model = Clothes::class;

    public function __construct(
        protected ClothesBuilderInterface $clothesBuilder,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
    }

    protected function makeEntity(Model $model): ClothesInterface
    {
        return $this->clothesBuilder
            ->setId($model->id)
            ->setName($model->name)
            ->setPhoto($model->photo)
            ->addStylePrimaries(...$model->styles()->allRelatedIds()->toArray())
            ->addEventPrimaries(...$model->events()->allRelatedIds()->toArray())
            ->addSeasonPrimaries(...$model->seasons()->allRelatedIds()->toArray())
            ->make();
    }
}
