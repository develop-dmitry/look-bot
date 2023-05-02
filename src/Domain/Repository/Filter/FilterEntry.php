<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Filter;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterEntryInterface;
use Look\Domain\Repository\LogicOperator;

class FilterEntry implements FilterEntryInterface
{
    public function __construct(
        protected string $column,
        protected mixed $values,
        protected LogicOperator $logicOperator,
        protected bool $not
    ) {
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getValues(): mixed
    {
        return $this->values;
    }

    public function getLogicOperator(): LogicOperator
    {
        return $this->logicOperator;
    }

    public function isNot(): bool
    {
        return $this->not;
    }

}
