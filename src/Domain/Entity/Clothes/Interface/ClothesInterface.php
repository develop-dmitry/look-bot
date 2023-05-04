<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Clothes\Interface;

use Look\Domain\Entity\Season\Interface\SeasonInterface;
use Look\Domain\Property\UseEvent\UseEventInterface;
use Look\Domain\Property\UseId\UseIdInterface;
use Look\Domain\Property\UseName\UseNameInterface;
use Look\Domain\Property\UsePhoto\UsePhotoInterface;
use Look\Domain\Property\UseStyle\UseStyleInterface;
use Look\Domain\Storage\Exception\StorageException;

interface ClothesInterface extends
    UseIdInterface,
    UseNameInterface,
    UsePhotoInterface,
    UseStyleInterface,
    UseEventInterface
{
    /**
     * @return SeasonInterface[]
     * @throws StorageException
     */
    public function getSeasons(): array;

    /**
     * @param int ...$seasonPrimary
     * @return $this
     */
    public function addSeasons(int ...$seasonPrimary): static;
}
