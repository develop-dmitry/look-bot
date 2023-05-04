<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Makeup\Interface;

use Look\Domain\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Builder\UseEvent\UseEventInterface;
use Look\Domain\Builder\UseId\UseIdInterface;
use Look\Domain\Builder\UseLevel\UseLevelInterface;
use Look\Domain\Builder\UseName\UseNameInterface;
use Look\Domain\Builder\UsePhoto\UsePhotoInterface;
use Look\Domain\Builder\UseStyle\UseStyleInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface MakeupBuilderInterface extends
    UseIdInterface,
    UseNameInterface,
    UsePhotoInterface,
    UseLevelInterface,
    UseStyleInterface,
    UseEventInterface
{
    /**
     * @return MakeupInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): MakeupInterface;
}
