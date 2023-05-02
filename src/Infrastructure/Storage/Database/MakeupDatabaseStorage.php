<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Database;

use App\Models\Makeup;
use Illuminate\Database\Eloquent\Model;
use Look\Domain\Entity\Makeup\Interface\MakeupBuilderInterface;
use Look\Domain\Entity\Makeup\Interface\MakeupInterface;
use Psr\Log\LoggerInterface;

class MakeupDatabaseStorage extends AbstractDatabaseStorage
{
    protected string $model = Makeup::class;

    public function __construct(
        protected MakeupBuilderInterface $makeupBuilder,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
    }

    protected function makeEntity(Model $model): MakeupInterface
    {
        return $this->makeupBuilder
            ->setId($model->id)
            ->setName($model->name)
            ->setLevel($model->level)
            ->setPhoto($model->photo)
            ->addStylePrimaries(...$model->styles()->allRelatedIds()->toArray())
            ->addEventPrimaries(...$model->events()->allRelatedIds()->toArray())
            ->make();
    }
}
