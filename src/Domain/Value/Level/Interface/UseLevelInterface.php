<?php

declare(strict_types=1);

namespace Look\Domain\Value\Level\Interface;

interface UseLevelInterface
{
    /**
     * @return LevelInterface
     */
    public function getLevel(): LevelInterface;

    /**
     * @param LevelInterface $level
     * @return $this
     */
    public function setLevel(LevelInterface $level): static;
}
