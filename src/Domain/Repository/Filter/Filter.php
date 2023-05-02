<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Filter;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterConditionInterface;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterEntryInterface;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterItemInterface;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterOptionFactoryInterface;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterRelationInterface;
use Look\Domain\Repository\LogicOperator;

class Filter implements FilterInterface
{
    /**
     * @var FilterConditionInterface[]
     */
    protected array $conditions = [];

    /**
     * @var FilterItemInterface[]
     */
    protected array $filters = [];

    /**
     * @var FilterRelationInterface[]
     */
    protected array $relations = [];

    /**
     * @var FilterEntryInterface[]
     */
    protected array $entries = [];

    public function __construct(
        protected FilterOptionFactoryInterface $filterOptionFactory
    ) {
    }

    public function addFilter(LogicOperator $logicOperator, FilterInterface $filter): FilterInterface
    {
        $this->filters[] = $this->filterOptionFactory->makeFilterItem($filter, $logicOperator);
        return $this;
    }

    public function addCondition(
        string $column,
        string $operator,
        mixed $value,
        LogicOperator $logicOperator = LogicOperator::AND
    ): FilterInterface {
        $this->conditions[] = $this->filterOptionFactory->makeFilterCondition(
            $column,
            $operator,
            $value,
            $logicOperator
        );
        return $this;
    }

    public function addRelation(
        string $relation,
        LogicOperator $logicOperator,
        FilterInterface $filter
    ): FilterInterface {
        $this->relations[] = $this->filterOptionFactory->makeFilterRelation($relation, $logicOperator, $filter);
        return $this;
    }

    public function addEntry(
        string $column,
        mixed $values,
        LogicOperator $logicOperator = LogicOperator::AND,
        bool $not = false
    ): FilterInterface {
        $this->entries[] = $this->filterOptionFactory->makeFilterEntry($column, $values, $logicOperator, $not);
        return $this;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getRelations(): array
    {
        return $this->relations;
    }

    public function getEntries(): array
    {
        return $this->entries;
    }
}
