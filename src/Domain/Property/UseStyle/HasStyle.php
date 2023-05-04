<?php

declare(strict_types=1);

namespace Look\Domain\Property\UseStyle;

use Look\Domain\Entity\Style\Interface\StyleInterface;

trait HasStyle
{
    /**
     * @var StyleInterface[]
     */
    protected array $styles = [];

    /**
     * @var int[]
     */
    protected array $getStylesQueue = [];

    public function getStyles(): array
    {
        if (!empty($this->getStylesQueue)) {
            foreach ($this->styleRepository->getItemsById($this->getStylesQueue) as $style) {
                $this->styles[] = $style;
            }

            $this->getStylesQueue = [];
        }

        return $this->styles;
    }

    public function addStyles(int ...$stylePrimary): static
    {
        $this->getStylesQueue = array_merge($this->getStylesQueue, $stylePrimary);
        return $this;
    }
}
