<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter\Filter;

use Look\Domain\Repository\LogicOperator;

interface FilterEntryInterface
{
    /**
     * @return string
     */
    public function getColumn(): string;

    /**
     * @return mixed
     */
    public function getValues(): mixed;

    /**
     * @return LogicOperator
     */
    public function getLogicOperator(): LogicOperator;

    /**
     * @return bool
     */
    public function isNot(): bool;
}
