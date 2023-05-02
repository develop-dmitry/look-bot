<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter\Filter;

use Look\Domain\Repository\LogicOperator;

interface FilterOptionFactoryInterface
{
    public function makeFilterItem(FilterInterface $filter, LogicOperator $logicOperator): FilterItemInterface;

    public function makeFilterCondition(
        string $column,
        string $operator,
        mixed $value,
        LogicOperator $logicOperator
    ): FilterConditionInterface;

    public function makeFilterRelation(
        string $relation,
        LogicOperator $logicOperator,
        FilterInterface $filter
    ): FilterRelationInterface;

    public function makeFilterEntry(
        string $column,
        mixed $values,
        LogicOperator $logicOperator,
        bool $not
    ): FilterEntryInterface;
}
