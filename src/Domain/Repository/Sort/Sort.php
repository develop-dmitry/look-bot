<?php

declare(strict_types=1);

namespace Look\Domain\Repository\Sort;

use Look\Domain\Repository\Interface\Parameter\Sort\SortInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortItemInterface;
use Look\Domain\Repository\Interface\Parameter\Sort\SortOptionFactoryInterface;

class Sort implements SortInterface
{
    /**
     * @var SortItemInterface[]
     */
    protected array $sorts = [];

    public function __construct(
        protected SortOptionFactoryInterface $sortOptionFactory
    ) {
    }

    public function addSort(string $column, string $direction = 'asc', int $priority = 1): SortInterface
    {
        $this->sorts[] = $this->sortOptionFactory->makeSortItem($column, $direction, $priority);
        return $this;
    }

    public function getSorts(): array
    {
        usort($this->sorts, static function (SortItemInterface $a, SortItemInterface $b) {
            if ($a->getPriority() > $b->getPriority()) {
                return 1;
            }

            if ($a->getPriority() < $b->getPriority()) {
                return -1;
            }

            return 0;
        });

        return $this->sorts;
    }
}
