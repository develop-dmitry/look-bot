<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter\Filter;

use Look\Domain\Repository\LogicOperator;

interface FilterConditionInterface
{
    /**
     * @return string
     */
    public function getColumn(): string;

    /**
     * @return string
     */
    public function getOperator(): string;

    /**
     * @return mixed
     */
    public function getValue(): mixed;

    /**
     * @return LogicOperator
     */
    public function getLogicOperator(): LogicOperator;
}
