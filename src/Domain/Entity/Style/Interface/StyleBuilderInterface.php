<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Style\Interface;

use Look\Domain\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Builder\UseId\UseIdInterface;
use Look\Domain\Builder\UseName\UseNameInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface StyleBuilderInterface extends UseIdInterface, UseNameInterface
{
    /**
     * @return StyleInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): StyleInterface;
}
