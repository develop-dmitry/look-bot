<?php

declare(strict_types=1);

namespace Look\Domain\Weather\Interface;

use Closure;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;

interface WeatherCacheInterface
{
    public function getWeather(GeoLocationInterface $geoLocation, Closure $callback): array;
}
