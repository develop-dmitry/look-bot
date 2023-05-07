<?php

declare(strict_types=1);

namespace Look\Infrastructure\Cache\Weather;

use Closure;
use Illuminate\Support\Facades\Cache;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\Weather\Interface\WeatherCacheInterface;

class WeatherCache implements WeatherCacheInterface
{
    protected int $ttl = 14400;

    protected string $keyPattern = 'weather_:lat_:lon';

    public function getWeather(GeoLocationInterface $geoLocation, Closure $callback): array
    {
        return Cache::remember($this->getCacheKey($geoLocation), $this->ttl, $callback);
    }

    protected function getCacheKey(GeoLocationInterface $geoLocation): string
    {
        $lat = round($geoLocation->getLat()->getValue(), 1);
        $lon = round($geoLocation->getLon()->getValue(), 1);

        return str_replace([':lat', ':lon'], [$lat, $lon], $this->keyPattern);
    }
}
