<?php

declare(strict_types=1);

namespace Look\Application\Weather\GetWeather\Interface;

use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\TimeOfDay\TimeOfDay;

interface GetWeatherRequestInterface
{
    /**
     * @return GeoLocationInterface
     */
    public function getGeoLocation(): GeoLocationInterface;

    /**
     * @return TimeOfDay
     */
    public function getTimeOfDay(): TimeOfDay;
}
