<?php

declare(strict_types=1);

namespace Look\Application\Weather\GetWeather;

use Look\Application\Weather\GetWeather\Interface\GetWeatherRequestInterface;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\TimeOfDay\TimeOfDay;

class GetWeatherRequest implements GetWeatherRequestInterface
{
    public function __construct(
        protected GeoLocationInterface $geoLocation,
        protected TimeOfDay $timeOfDay
    ) {
    }

    public function getGeoLocation(): GeoLocationInterface
    {
        return $this->geoLocation;
    }

    public function getTimeOfDay(): TimeOfDay
    {
        return $this->timeOfDay;
    }
}
