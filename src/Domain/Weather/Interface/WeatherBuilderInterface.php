<?php

declare(strict_types=1);

namespace Look\Domain\Weather\Interface;

use Look\Application\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Value\Exception\InvalidValueException;

interface WeatherBuilderInterface
{
    public function setTemperature(int $temperature): self;

    public function setMinTemperature(int $temperature): self;

    public function setMaxTemperature(int $temperature): self;

    public function setGeoLocation(GeoLocationInterface $geoLocation): self;

    /**
     * @return WeatherInterface
     * @throws InvalidValueException|NoRequiredPropertiesException
     */
    public function make(): WeatherInterface;
}
