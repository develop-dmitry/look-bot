<?php

declare(strict_types=1);

namespace Look\Application\Builder\UseLevel;

trait HasLevel
{
    public function setLevel(int $level): static
    {
        $this->values['level'] = $level;
        return $this;
    }
}
