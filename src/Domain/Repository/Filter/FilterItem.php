<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Filter;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Repository\Interface\Parameter\Filter\FilterItemInterface;
use Look\Domain\Repository\LogicOperator;

class FilterItem implements FilterItemInterface
{
    public function __construct(
        protected FilterInterface $filter,
        protected LogicOperator $logicOperator
    ) {
    }

    public function getFilter(): FilterInterface
    {
        return $this->filter;
    }

    public function getLogicOperator(): LogicOperator
    {
        return $this->logicOperator;
    }
}
