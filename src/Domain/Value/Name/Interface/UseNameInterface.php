<?php

declare(strict_types=1);

namespace Look\Domain\Value\Name\Interface;

interface UseNameInterface
{
    /**
     * @return NameInterface
     */
    public function getName(): NameInterface;

    /**
     * @param NameInterface $name
     * @return $this
     */
    public function setName(NameInterface $name): static;
}
