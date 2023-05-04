<?php

declare(strict_types=1);

namespace Look\Domain\Entity\MessengerUser\Interface;

use Look\Domain\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Builder\UseId\UseIdInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface MessengerUserBuilderInterface extends UseIdInterface
{
    /**
     * @param string|null $handler
     * @return self
     */
    public function setMessengerHandler(?string $handler): self;

    /**
     * @return MessengerUserInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): MessengerUserInterface;
}
