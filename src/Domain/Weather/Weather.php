<?php

declare(strict_types=1);

namespace Look\Domain\Weather;

use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Value\Temperature\TemperatureInterface;
use Look\Domain\Weather\Interface\WeatherInterface;

class Weather implements WeatherInterface
{
    protected TemperatureInterface $temperature;

    protected TemperatureInterface $minTemperature;

    protected TemperatureInterface $maxTemperature;

    protected GeoLocationInterface $geoPosition;

    public function getTemperature(): TemperatureInterface
    {
        return $this->temperature;
    }

    public function setTemperature(TemperatureInterface $temperature): WeatherInterface
    {
        $this->temperature = $temperature;
        return $this;
    }

    public function getMinTemperature(): TemperatureInterface
    {
        return $this->minTemperature;
    }

    public function setMinTemperature(TemperatureInterface $temperature): WeatherInterface
    {
        $this->minTemperature = $temperature;
        return $this;
    }

    public function getMaxTemperature(): TemperatureInterface
    {
        return $this->maxTemperature;
    }

    public function setMaxTemperature(TemperatureInterface $temperature): WeatherInterface
    {
        $this->maxTemperature = $temperature;
        return $this;
    }

    public function getGeoLocation(): GeoLocationInterface
    {
        return $this->geoPosition;
    }

    public function setGeoLocation(GeoLocationInterface $geoPosition): WeatherInterface
    {
        $this->geoPosition = $geoPosition;
        return $this;
    }
}
