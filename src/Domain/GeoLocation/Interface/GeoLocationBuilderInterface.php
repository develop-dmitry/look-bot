<?php

declare(strict_types=1);

namespace Look\Domain\GeoLocation\Interface;

use Look\Application\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\Value\Exception\InvalidValueException;

interface GeoLocationBuilderInterface
{
    /**
     * @param float $coordinate
     * @return self
     */
    public function setLat(float $coordinate): self;

    /**
     * @param float $coordinate
     * @return self
     */
    public function setLon(float $coordinate): self;

    /**
     * @param string $address
     * @return self
     */
    public function setAddress(string $address): self;

    /**
     * @return GeoLocationInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): GeoLocationInterface;
}
