<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Database;

use App\Models\Style;
use Illuminate\Database\Eloquent\Model;
use Look\Domain\Entity\Style\Interface\StyleBuilderInterface;
use Look\Domain\Entity\Style\Interface\StyleInterface;
use Psr\Log\LoggerInterface;

class StyleDatabaseStorage extends AbstractDatabaseStorage
{
    protected string $model = Style::class;

    public function __construct(
        protected StyleBuilderInterface $styleBuilder,
        LoggerInterface $logger
    ) {
        parent::__construct($logger);
    }

    protected function makeEntity(Model $model): StyleInterface
    {
        return $this->styleBuilder
            ->setId($model->id)
            ->setName($model->name)
            ->make();
    }
}
