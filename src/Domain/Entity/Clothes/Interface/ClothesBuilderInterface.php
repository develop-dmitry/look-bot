<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Clothes\Interface;

use Look\Domain\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Builder\UseEvent\UseEventInterface;
use Look\Domain\Builder\UseId\UseIdInterface;
use Look\Domain\Builder\UseName\UseNameInterface;
use Look\Domain\Builder\UsePhoto\UsePhotoInterface;
use Look\Domain\Builder\UseStyle\UseStyleInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface ClothesBuilderInterface extends
    UseIdInterface,
    UseNameInterface,
    UsePhotoInterface,
    UseStyleInterface,
    UseEventInterface
{
    public function addSeasonPrimaries(int ...$seasonPrimaries): static;

    /**
     * @return ClothesInterface
     * @throws NoRequiredPropertiesException
     * @throws InvalidValueException
     */
    public function make(): ClothesInterface;
}
