<?php

declare(strict_types=1);

namespace Look\Domain\Storage\Interface\Request;

interface InsertRequestInterface
{
    /**
     * @return array
     */
    public function getColumns(): array;

    /**
     * @return array
     */
    public function getRelations(): array;
}
