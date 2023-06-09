<?php

declare(strict_types=1);

namespace Look\Application\Builder\UseName;

interface UseNameInterface
{
    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static;
}
