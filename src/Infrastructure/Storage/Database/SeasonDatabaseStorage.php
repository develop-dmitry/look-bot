<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Database;

use App\Models\Season;
use Illuminate\Database\Eloquent\Model;
use Look\Domain\Entity\Season\Interface\SeasonBuilderInterface;
use Look\Domain\Entity\Season\Interface\SeasonInterface;
use Psr\Log\LoggerInterface;

class SeasonDatabaseStorage extends AbstractDatabaseStorage
{
    protected string $model = Season::class;

    public function __construct(
        protected SeasonBuilderInterface $seasonBuilder,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
    }

    protected function makeEntity(Model $model): SeasonInterface
    {
        return $this->seasonBuilder
            ->setId($model->id)
            ->setName($model->name)
            ->make();
    }
}
