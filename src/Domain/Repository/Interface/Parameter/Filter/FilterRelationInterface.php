<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter\Filter;

use Look\Domain\Repository\LogicOperator;

interface FilterRelationInterface
{
    public function getRelation(): string;

    public function getLogicOperator(): LogicOperator;

    public function getFilter(): FilterInterface;
}
