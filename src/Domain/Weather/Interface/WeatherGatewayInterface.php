<?php

declare(strict_types=1);

namespace Look\Domain\Weather\Interface;

use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\TimeOfDay\TimeOfDay;
use Look\Domain\Weather\Exception\GetWeatherException;

interface WeatherGatewayInterface
{
    /**
     * @param GeoLocationInterface $geoLocation
     * @param TimeOfDay $timeOfDay
     * @return WeatherInterface
     * @throws GetWeatherException
     */
    public function getWeather(GeoLocationInterface $geoLocation, TimeOfDay $timeOfDay): WeatherInterface;
}
