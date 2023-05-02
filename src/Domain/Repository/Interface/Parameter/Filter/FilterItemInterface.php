<?php


declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter\Filter;

use Look\Domain\Repository\LogicOperator;

interface FilterItemInterface
{
    /**
     * @return FilterInterface
     */
    public function getFilter(): FilterInterface;

    /**
     * @return LogicOperator
     */
    public function getLogicOperator(): LogicOperator;
}
