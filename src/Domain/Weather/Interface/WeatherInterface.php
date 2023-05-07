<?php

declare(strict_types=1);

namespace Look\Domain\Weather\Interface;

use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Value\Temperature\TemperatureInterface;

interface WeatherInterface
{
    /**
     * @return TemperatureInterface
     */
    public function getTemperature(): TemperatureInterface;

    /**
     * @param TemperatureInterface $temperature
     * @return self
     */
    public function setTemperature(TemperatureInterface $temperature): self;

    /**
     * @return TemperatureInterface
     */
    public function getMinTemperature(): TemperatureInterface;

    /**
     * @param TemperatureInterface $temperature
     * @return self
     */
    public function setMinTemperature(TemperatureInterface $temperature): self;

    /**
     * @return TemperatureInterface
     */
    public function getMaxTemperature(): TemperatureInterface;

    /**
     * @param TemperatureInterface $temperature
     * @return self
     */
    public function setMaxTemperature(TemperatureInterface $temperature): self;

    /**
     * @return GeoLocationInterface
     */
    public function getGeoLocation(): GeoLocationInterface;

    /**
     * @param GeoLocationInterface $geoPosition
     * @return self
     */
    public function setGeoLocation(GeoLocationInterface $geoPosition): self;
}
