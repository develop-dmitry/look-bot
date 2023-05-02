<?php

declare(strict_types=1);

namespace Look\Domain\Storage\Interface\Request;

use Look\Domain\Repository\Interface\Parameter\Filter\FilterInterface;

interface DeleteRequestInterface
{
    /**
     * @return FilterInterface
     */
    public function getFilter(): FilterInterface;
}
