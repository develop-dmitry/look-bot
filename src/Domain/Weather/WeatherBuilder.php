<?php

declare(strict_types=1);

namespace Look\Domain\Weather;

use Look\Application\Builder\AbstractBuilder;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Value\Factory\ValueFactoryInterface;
use Look\Domain\Weather\Interface\WeatherBuilderInterface;
use Look\Domain\Weather\Interface\WeatherInterface;

class WeatherBuilder extends AbstractBuilder implements WeatherBuilderInterface
{
    protected array $required = ['temperature', 'min_temperature', 'max_temperature', 'geo_location'];

    public function __construct(
        protected ValueFactoryInterface $valueFactory
    ) {
    }

    public function setTemperature(int $temperature): WeatherBuilderInterface
    {
        $this->values['temperature'] = $temperature;
        return $this;
    }

    public function setMinTemperature(int $temperature): WeatherBuilderInterface
    {
        $this->values['min_temperature'] = $temperature;
        return $this;
    }

    public function setMaxTemperature(int $temperature): WeatherBuilderInterface
    {
        $this->values['max_temperature'] = $temperature;
        return $this;
    }

    public function setGeoLocation(GeoLocationInterface $geoLocation): WeatherBuilderInterface
    {
        $this->values['geo_location'] = $geoLocation;
        return $this;
    }

    public function make(): WeatherInterface
    {
        $this->checkRequired();

        $weather = (new Weather())
            ->setTemperature($this->valueFactory->makeTemperature($this->getValue('temperature')))
            ->setMinTemperature($this->valueFactory->makeTemperature($this->getValue('min_temperature')))
            ->setMaxTemperature($this->valueFactory->makeTemperature($this->getValue('max_temperature')))
            ->setGeoLocation($this->getValue('geo_location'));

        $this->reset();

        return $weather;
    }
}
