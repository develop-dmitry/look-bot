<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Season\Interface;

use Look\Domain\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Builder\UseId\UseIdInterface;
use Look\Domain\Builder\UseName\UseNameInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface SeasonBuilderInterface extends UseIdInterface, UseNameInterface
{
    /**
     * @return SeasonInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): SeasonInterface;
}
