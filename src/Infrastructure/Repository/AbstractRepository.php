<?php

declare(strict_types=1);

namespace Look\Infrastructure\Repository;

use Look\Domain\Repository\Interface\Parameter\ParameterFactoryInterface;
use Look\Domain\Storage\Exception\StorageException;
use Look\Domain\Storage\Interface\Request\RequestFactoryInterface;
use Look\Domain\Storage\Interface\StorageInterface;

abstract class AbstractRepository
{
    public function __construct(
        protected StorageInterface $storage,
        protected RequestFactoryInterface $requestFactory,
        protected ParameterFactoryInterface $parameterFactory
    ) {
    }

    /**
     * @throws StorageException
     */
    public function getItemsById(array $ids): array
    {
        $filter = $this->parameterFactory->makeFilter()
            ->addEntry('id', $ids);
        $selectRequest = $this->requestFactory->makeSelectRequest($filter);

        return $this->storage->select($selectRequest);
    }
}
