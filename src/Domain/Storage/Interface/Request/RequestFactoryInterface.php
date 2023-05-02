<?php

declare(strict_types=1);

namespace Look\Domain\Storage\Interface\Request;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Repository\Interface\Parameter\Pagination\PaginationInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortInterface;

interface RequestFactoryInterface
{
    public function makeInsertRequest(array $properties, array $relations = []): InsertRequestInterface;

    public function makeUpdateRequest(
        string|int $primary,
        array $properties,
        array $relations = []
    ): UpdateRequestInterface;

    public function makeDeleteRequest(FilterInterface $filter): DeleteRequestInterface;

    public function makeSelectRequest(
        ?FilterInterface $filter = null,
        ?SortInterface $sort = null,
        ?PaginationInterface $pagination = null
    ): SelectRequestInterface;
}
