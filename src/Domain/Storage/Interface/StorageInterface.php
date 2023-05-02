<?php

declare(strict_types=1);

namespace Look\Domain\Storage\Interface;

use Look\Domain\Storage\Exception\StorageException;
use Look\Domain\Storage\Interface\Request\DeleteRequestInterface;
use Look\Domain\Storage\Interface\Request\InsertRequestInterface;
use Look\Domain\Storage\Interface\Request\SelectRequestInterface;
use Look\Domain\Storage\Interface\Request\UpdateRequestInterface;

interface StorageInterface
{
    /**
     * @param SelectRequestInterface $request
     * @return mixed
     * @throws StorageException
     */
    public function select(SelectRequestInterface $request): array;

    /**
     * @param UpdateRequestInterface $request
     * @return mixed
     * @throws StorageException
     */
    public function update(UpdateRequestInterface $request): bool;

    /**
     * @param DeleteRequestInterface $request
     * @return mixed
     * @throws StorageException
     */
    public function delete(DeleteRequestInterface $request): bool;

    /**
     * @param InsertRequestInterface $request
     * @return int|string
     * @throws StorageException
     */
    public function insert(InsertRequestInterface $request): int|string;
}
