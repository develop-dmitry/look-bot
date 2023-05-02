<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Database;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Look\Domain\Entity\Event\Interface\EventBuilderInterface;
use Look\Domain\Entity\Event\Interface\EventInterface;
use Psr\Log\LoggerInterface;

class EventDatabaseStorage extends AbstractDatabaseStorage
{
    protected string $model = Event::class;

    public function __construct(
        protected EventBuilderInterface $eventBuilder,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
    }

    protected function makeEntity(Model $model): EventInterface
    {
        return $this->eventBuilder
            ->setId($model->id)
            ->setName($model->name)
            ->make();
    }
}
