<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Request;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Repository\Interface\Parameter\Pagination\PaginationInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortInterface;
use Look\Domain\Storage\Interface\Request\DeleteRequestInterface;
use Look\Domain\Storage\Interface\Request\InsertRequestInterface;
use Look\Domain\Storage\Interface\Request\RequestFactoryInterface;
use Look\Domain\Storage\Interface\Request\SelectRequestInterface;
use Look\Domain\Storage\Interface\Request\UpdateRequestInterface;

class RequestFactory implements RequestFactoryInterface
{
    public function makeInsertRequest(array $properties, array $relations = []): InsertRequestInterface
    {
        return new InsertRequest($properties, $relations);
    }

    public function makeUpdateRequest(
        int|string $primary,
        array $properties,
        array $relations = []
    ): UpdateRequestInterface {
        return new UpdateRequest($primary, $properties, $relations);
    }

    public function makeDeleteRequest(FilterInterface $filter): DeleteRequestInterface
    {
        return new DeleteRequest($filter);
    }

    public function makeSelectRequest(
        FilterInterface $filter = null,
        SortInterface $sort = null,
        PaginationInterface $pagination = null
    ): SelectRequestInterface {
        return new SelectRequest($filter, $sort, $pagination);
    }
}
