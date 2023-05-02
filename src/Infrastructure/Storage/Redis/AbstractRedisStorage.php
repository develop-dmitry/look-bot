<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Redis;

use Illuminate\Support\Facades\Redis;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Storage\Exception\StorageException;
use Look\Domain\Storage\Interface\Request\DeleteRequestInterface;
use Look\Domain\Storage\Interface\Request\InsertRequestInterface;
use Look\Domain\Storage\Interface\Request\SelectRequestInterface;
use Look\Domain\Storage\Interface\Request\UpdateRequestInterface;
use Look\Domain\Storage\Interface\StorageInterface;
use Psr\Log\LoggerInterface;
use RedisException;

abstract class AbstractRedisStorage implements StorageInterface
{
    protected string $entity = '';

    protected string $primaryKey = 'id';

    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    public function select(SelectRequestInterface $request): array
    {
        [$primary, $fields] = $this->splitColumns($this->getColumnsFromFilter($request->getFilter()));

        $result = [];

        try {
            foreach ($fields as $key => $value) {
                $result[$key] = Redis::get($this->getKey($primary, $key));
            }
        } catch (RedisException $exception) {
            throw new StorageException($exception->getMessage());
        }

        return $result;
    }

    public function update(UpdateRequestInterface $request): bool
    {
        $this->saveValue($request->getColumns());

        return true;
    }

    public function insert(InsertRequestInterface $request): int|string
    {
        $this->saveValue($request->getColumns());

        return 'Value inserted successfully';
    }

    public function delete(DeleteRequestInterface $request): bool
    {
        [$primary, $fields] = $this->splitColumns($this->getColumnsFromFilter($request->getFilter()));

        try {
            foreach ($fields as $key => $value) {
                Redis::del($this->getKey($primary, $key));
            }
        } catch (RedisException $exception) {
            throw new StorageException($exception->getMessage());
        }

        return true;
    }

    /**
     * @throws StorageException
     */
    protected function saveValue(array $columns): void
    {
        [$primary, $fields] = $this->splitColumns($columns);

        try {
            foreach ($fields as $key => $value) {
                Redis::set($this->getKey($primary, $key), $value);
            }
        } catch (RedisException $exception) {
            throw new StorageException($exception->getMessage());
        }
    }

    protected function getColumnsFromFilter(FilterInterface $filter): array
    {
        $columns = [];

        foreach ($filter->getConditions() as $condition) {
            $columns[$condition->getColumn()] = $condition->getValue();
        }

        return $columns;
    }

    /**
     * @throws StorageException
     */
    protected function splitColumns(array $columns): array
    {
        return [$this->getPrimary($columns), $this->getFields($columns)];
    }

    /**
     * @throws StorageException
     */
    protected function getPrimary(array $columns): int|string
    {
        if (!isset($columns[$this->primaryKey])) {
            $this->logger->emergency('Columns does not exists primary key', ['columns' => $columns]);

            throw new StorageException('Columns does not exists primary key');
        }

        return $columns[$this->primaryKey];
    }

    protected function getFields(array $columns): array
    {
        $fields = [];

        foreach ($columns as $key => $column) {
            if ($key !== $this->primaryKey) {
                $fields[$key] = $column;
            }
        }

        return $fields;
    }

    protected function getKey(int|string $primaryKey, string $field): string
    {
        return "$this->entity:$primaryKey:$field";
    }
}
