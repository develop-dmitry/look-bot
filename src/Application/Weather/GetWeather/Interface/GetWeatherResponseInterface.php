<?php

declare(strict_types=1);

namespace Look\Application\Weather\GetWeather\Interface;

use Look\Domain\Weather\Interface\WeatherInterface;

interface GetWeatherResponseInterface
{
    /**
     * @return WeatherInterface|null
     */
    public function getWeather(): ?WeatherInterface;

    /**
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * @return string
     */
    public function getError(): string;
}
