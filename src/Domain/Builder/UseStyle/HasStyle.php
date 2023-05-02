<?php

declare(strict_types=1);

namespace Look\Domain\Builder\UseStyle;

trait HasStyle
{
    public function addStylePrimaries(int ...$stylePrimaries): static
    {
        $this->values['style_primaries'] = array_merge($this->getValue('style_primaries', []), $stylePrimaries);
        return $this;
    }
}
