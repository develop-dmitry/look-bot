<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Database;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LogicException;
use Look\Domain\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Repository\Interface\Parameter\Pagination\PaginationInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortInterface;
use Look\Domain\Storage\Exception\StorageException;
use Look\Domain\Storage\Interface\Request\DeleteRequestInterface;
use Look\Domain\Storage\Interface\Request\InsertRequestInterface;
use Look\Domain\Storage\Interface\Request\SelectRequestInterface;
use Look\Domain\Storage\Interface\Request\UpdateRequestInterface;
use Look\Domain\Storage\Interface\StorageInterface;
use Look\Domain\Value\Exception\InvalidValueException;
use Psr\Log\LoggerInterface;

abstract class AbstractDatabaseStorage implements StorageInterface
{
    protected string $model;

    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    public function select(SelectRequestInterface $request): array
    {
        $items = $this->getItems($request->getFilter(), $request->getSort(), $request->getPagination());

        $result = [];

        foreach ($items as $item) {
            try {
                $result[] = $this->makeEntity($item);
            } catch (NoRequiredPropertiesException|InvalidValueException $exception) {
                $this->logger->emergency(
                    'Получены неконсистентные данные',
                    ['item' => $item, 'exception' => $exception]
                );
            }
        }

        return $result;
    }

    public function update(UpdateRequestInterface $request): bool
    {
        $model = $this->model::find($request->getPrimary());

        if (!$model) {
            throw new StorageException("Model with primary key {$request->getPrimary()} not found");
        }

        $this->saveRelations($model, $request->getRelations());

        $model->fill($request->getColumns());

        return $model->save();
    }

    public function delete(DeleteRequestInterface $request): bool
    {
        $items = $this->getItems($request->getFilter());

        DB::transaction(static function () use ($items) {
            try {
                foreach ($items as $item) {
                    $isDelete = $item->delete();

                    if (!$isDelete) {
                        throw new StorageException("Failed to delete item with primary key {$item->getKey()}");
                    }
                }
            } catch (LogicException $exception) {
                throw new StorageException($exception->getMessage());
            }
        });

        return true;
    }

    public function insert(InsertRequestInterface $request): int
    {
        try {
            $model = new $this->model;
            $model->fill($request->getColumns());

            $success = $model->save();

            if (!$success) {
                throw new StorageException('Failed to insert record');
            }

            $this->saveRelations($model, $request->getRelations());

            return $model->getKey();
        } catch (MassAssignmentException $exception) {
            throw new StorageException($exception->getMessage());
        }
    }

    protected function getItems(
        ?FilterInterface $filter = null,
        ?SortInterface $sort = null,
        ?PaginationInterface $pagination = null
    ): Collection {
        $builder = $this->model::query();

        if ($sort) {
            $this->useSort($sort, $builder);
        }

        if ($pagination) {
            $this->usePagination($pagination, $builder);
        }

        if ($filter) {
            $this->useFilter($filter, $builder);
        }

        return $builder->get();
    }

    protected function useSort(SortInterface $sort, Builder $builder): void
    {
        foreach ($sort->getSorts() as $sortItem) {
            $builder->orderBy($sortItem->getColumn(), $sortItem->getDirection());
        }
    }

    protected function usePagination(PaginationInterface $pagination, Builder $builder): void
    {
        // todo допилить пагинацию
        // $builder->paginate($pagination->getCount(), [], 'page', $pagination->getPage());
    }

    protected function useFilter(FilterInterface $filter, Builder $builder): void
    {
        foreach ($filter->getConditions() as $condition) {
            $builder->where(
                $condition->getColumn(),
                $condition->getOperator(),
                $condition->getValue(),
                $condition->getLogicOperator()->value
            );
        }

        foreach ($filter->getEntries() as $entry) {
            $builder->whereIn(
                $entry->getColumn(),
                $entry->getValues(),
                $entry->getLogicOperator()->value,
                $entry->isNot()
            );
        }

        foreach ($filter->getFilters() as $nestedFilter) {
            $builder->where(
                fn (Builder $query) => $this->useFilter($nestedFilter->getFilter(), $query),
                null,
                null,
                $nestedFilter->getLogicOperator()->value
            );
        }

        foreach ($filter->getRelations() as $relation) {
            $builder->has(
                $relation->getRelation(),
                '>=',
                1,
                $relation->getLogicOperator()->value,
                fn (Builder $query) => $this->useFilter($relation->getFilter(), $query)
            );
        }
    }

    protected function saveRelations(Model $model, array $relations): void
    {
        foreach ($relations as $relationName => $relation) {
            if ($model->isRelation($relationName) && method_exists($model, $relationName)) {
                $model->$relationName()->sync($relation);
            }
        }
    }

    /**
     * @param Model $model
     * @return mixed
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    abstract protected function makeEntity(Model $model): mixed;
}
