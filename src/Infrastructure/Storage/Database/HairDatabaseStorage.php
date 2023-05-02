<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Database;

use App\Models\Hair;
use Illuminate\Database\Eloquent\Model;
use Look\Domain\Entity\Hair\Interface\HairBuilderInterface;
use Look\Domain\Entity\Hair\Interface\HairInterface;
use Psr\Log\LoggerInterface;

class HairDatabaseStorage extends AbstractDatabaseStorage
{
    protected string $model = Hair::class;

    public function __construct(
        protected HairBuilderInterface $hairBuilder,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
    }

    protected function makeEntity(Model $model): HairInterface
    {
        return $this->hairBuilder
            ->setId($model->id)
            ->setName($model->name)
            ->setPhoto($model->photo)
            ->setLevel($model->level)
            ->addStylePrimaries(...$model->styles()->allRelatedIds()->toArray())
            ->addEventPrimaries(...$model->events()->allRelatedIds()->toArray())
            ->make();
    }
}
