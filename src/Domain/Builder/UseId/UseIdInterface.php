<?php

declare(strict_types=1);

namespace Look\Domain\Builder\UseId;

interface UseIdInterface
{
    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): static;
}
