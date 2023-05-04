<?php

declare(strict_types=1);

namespace Look\Domain\Builder\UseStyle;

interface UseStyleInterface
{
    public function addStylePrimaries(int ...$stylePrimaries): static;
}
