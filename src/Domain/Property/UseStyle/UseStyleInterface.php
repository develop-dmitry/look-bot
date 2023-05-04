<?php

declare(strict_types=1);

namespace Look\Domain\Property\UseStyle;

use Look\Domain\Entity\Style\Interface\StyleInterface;
use Look\Domain\Storage\Exception\StorageException;

interface UseStyleInterface
{
    /**
     * @return StyleInterface[]
     * @throws StorageException
     */
    public function getStyles(): array;

    /**
     * @param int ...$stylePrimary
     * @return $this
     */
    public function addStyles(int ...$stylePrimary): static;
}
