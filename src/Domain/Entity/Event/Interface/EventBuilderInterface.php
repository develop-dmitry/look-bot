<?php

declare(strict_types=1);

namespace Look\Domain\Entity\Event\Interface;

use Look\Domain\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Builder\UseId\UseIdInterface;
use Look\Domain\Builder\UseName\UseNameInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface EventBuilderInterface extends UseIdInterface,UseNameInterface
{
    /**
     * @return EventInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): EventInterface;
}
