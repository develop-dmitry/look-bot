<?php

declare(strict_types=1);

namespace Look\Domain\Value\Id\Interface;

interface UseIdInterface
{
    /**
     * @return IdInterface|null
     */
    public function getId(): ?IdInterface;

    /**
     * @param IdInterface|null $id
     * @return $this
     */
    public function setId(?IdInterface $id): static;
}
