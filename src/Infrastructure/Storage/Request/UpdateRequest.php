<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Request;

use Look\Domain\Storage\Interface\Request\UpdateRequestInterface;

class UpdateRequest implements UpdateRequestInterface
{
    public function __construct(
        protected int|string $primary,
        protected array $columns,
        protected array $relations
    ) {
    }

    public function getPrimary(): int|string
    {
        return $this->primary;
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
