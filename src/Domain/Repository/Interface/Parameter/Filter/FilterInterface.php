<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter\Filter;

use Look\Domain\Repository\LogicOperator;

interface FilterInterface
{
    /**
     * @param LogicOperator $logicOperator
     * @param FilterInterface $filter
     * @return self
     */
    public function addFilter(LogicOperator $logicOperator, FilterInterface $filter): self;

    /**
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @param LogicOperator $logicOperator
     * @return self
     */
    public function addCondition(
        string $column,
        string $operator,
        mixed $value,
        LogicOperator $logicOperator = LogicOperator::AND
    ): self;

    /**
     * @param string $relation
     * @param LogicOperator $logicOperator
     * @param FilterInterface $filter
     * @return self
     */
    public function addRelation(string $relation, LogicOperator $logicOperator, FilterInterface $filter): self;

    /**
     * @param string $column
     * @param mixed $values
     * @param LogicOperator $logicOperator
     * @param bool $not
     * @return self
     */
    public function addEntry(
        string $column,
        mixed $values,
        LogicOperator $logicOperator = LogicOperator::AND,
        bool $not = false
    ): self;

    /**
     * @return FilterConditionInterface[]
     */
    public function getConditions(): array;

    /**
     * @return FilterItemInterface[]
     */
    public function getFilters(): array;

    /**
     * @return FilterRelationInterface[]
     */
    public function getRelations(): array;

    /**
     * @return FilterEntryInterface[]
     */
    public function getEntries(): array;
}
