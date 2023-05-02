<?php

declare(strict_types=1);

namespace Look\Infrastructure\Storage\Request;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;
use Look\Domain\Storage\Interface\Request\DeleteRequestInterface;

class DeleteRequest implements DeleteRequestInterface
{
    public function __construct(
        protected FilterInterface $filter
    ) {
    }

    public function getFilter(): FilterInterface
    {
        return $this->filter;
    }
}
