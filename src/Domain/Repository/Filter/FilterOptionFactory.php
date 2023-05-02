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

class FilterOptionFactory implements FilterOptionFactoryInterface
{
    public function makeFilterItem(FilterInterface $filter, LogicOperator $logicOperator): FilterItemInterface
    {
        return new FilterItem($filter, $logicOperator);
    }

    public function makeFilterCondition(
        string $column,
        string $operator,
        mixed $value,
        LogicOperator $logicOperator
    ): FilterConditionInterface {
        return new FilterCondition($column, $operator, $value, $logicOperator);
    }

    public function makeFilterRelation(
        string $relation,
        LogicOperator $logicOperator,
        FilterInterface $filter
    ): FilterRelationInterface {
        return new FilterRelation($relation, $logicOperator, $filter);
    }

    public function makeFilterEntry(
        string $column,
        mixed $values,
        LogicOperator $logicOperator,
        bool $not
    ): FilterEntryInterface {
        return new FilterEntry($column, $values, $logicOperator, $not);
    }
}
