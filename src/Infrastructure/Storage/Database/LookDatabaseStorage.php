<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Database;

use App\Models\Look;
use Illuminate\Database\Eloquent\Model;
use Look\Domain\Entity\Look\Interface\LookBuilderInterface;
use Look\Domain\Entity\Look\Interface\LookInterface;
use Psr\Log\LoggerInterface;

class LookDatabaseStorage extends AbstractDatabaseStorage
{
    protected string $model = Look::class;

    public function __construct(
        protected LookBuilderInterface $lookBuilder,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
    }

    protected function makeEntity(Model $model): LookInterface
    {
        return $this->lookBuilder
            ->setId($model->id)
            ->setName($model->name)
            ->setPhoto($model->photo)
            ->setLowerRangeTemperature($model->lower_temperature_range)
            ->setUpperRangeTemperature($model->upper_temperature_range)
            ->addClothesPrimaries(...$model->clothes()->allRelatedIds()->toArray())
            ->addHairPrimaries(...$model->hairs()->allRelatedIds()->toArray())
            ->addMakeupPrimaries(...$model->makeups()->allRelatedIds()->toArray())
            ->make();
    }
}
