<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Request;

use Look\Domain\Storage\Interface\Request\InsertRequestInterface;

class InsertRequest implements InsertRequestInterface
{
    public function __construct(
        protected array $columns,
        protected array $relations
    ) {
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getRelations(): array
    {
        return $this->relations;
    }
}
