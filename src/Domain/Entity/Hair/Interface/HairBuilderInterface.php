<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Hair\Interface;

use Look\Domain\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Builder\UseEvent\UseEventInterface;
use Look\Domain\Builder\UseId\UseIdInterface;
use Look\Domain\Builder\UseLevel\UseLevelInterface;
use Look\Domain\Builder\UseName\UseNameInterface;
use Look\Domain\Builder\UsePhoto\UsePhotoInterface;
use Look\Domain\Builder\UseStyle\UseStyleInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface HairBuilderInterface extends
    UseIdInterface,
    UseNameInterface,
    UsePhotoInterface,
    UseLevelInterface,
    UseStyleInterface,
    UseEventInterface
{
    /**
     * @return HairInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): HairInterface;
}
