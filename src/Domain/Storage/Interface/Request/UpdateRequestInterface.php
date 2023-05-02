<?php

declare(strict_types=1);

namespace Look\Domain\Storage\Interface\Request;

interface UpdateRequestInterface
{
    /**
     * @return int|string
     */
    public function getPrimary(): int|string;

    /**
     * @return array
     */
    public function getColumns(): array;

    /**
     * @return array
     */
    public function getRelations(): array;
}
