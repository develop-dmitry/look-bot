<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Interface\Parameter\Sort;

interface SortItemInterface
{
    public function getColumn(): string;

    public function getDirection(): string;

    public function getPriority(): int;
}
