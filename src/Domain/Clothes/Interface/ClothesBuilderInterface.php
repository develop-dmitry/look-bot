<?php

declare(strict_types=1);

namespace Look\Domain\Clothes\Interface;

use Look\Application\Builder\Exception\NoRequiredPropertiesException;
use Look\Application\Builder\UseId\UseIdInterface;
use Look\Application\Builder\UseName\UseNameInterface;
use Look\Application\Builder\UsePhoto\UsePhotoInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface ClothesBuilderInterface extends UseIdInterface, UsePhotoInterface, UseNameInterface
{
    /**
     * @param bool $isChosen
     * @return self
     */
    public function setChosen(bool $isChosen): self;

    /**
     * @return ClothesInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): ClothesInterface;
}
