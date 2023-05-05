<?php

declare(strict_types=1);

namespace Look\Domain\Value\Level\Trait;

use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Value\Level\Interface\LevelInterface;
use Look\Domain\Value\Level\Level;

trait HasLevel
{
    protected LevelInterface $level;

    public function getLevel(): LevelInterface
    {
        return $this->level;
    }

    public function setLevel(LevelInterface $level): static
    {
        $this->level = $level;
        return $this;
    }
}
