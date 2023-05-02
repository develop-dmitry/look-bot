<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Filter;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterConditionInterface;
use Look\Domain\Repository\LogicOperator;

class FilterCondition implements FilterConditionInterface
{
    public function __construct(
        protected string $column,
        protected string $operator,
        protected mixed $value,
        protected LogicOperator $logicOperator,
    ) {
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getLogicOperator(): LogicOperator
    {
        return $this->logicOperator;
    }
}
