<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Filter;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterRelationInterface;
use Look\Domain\Repository\LogicOperator;

class FilterRelation implements FilterRelationInterface
{
    public function __construct(
        protected string $relation,
        protected LogicOperator $logicOperator,
        protected FilterInterface $filter
    ) {
    }

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function getLogicOperator(): LogicOperator
    {
        return $this->logicOperator;
    }

    public function getFilter(): FilterInterface
    {
        return $this->filter;
    }
}
