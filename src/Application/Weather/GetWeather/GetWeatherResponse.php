<?php

declare(strict_types=1);

namespace Look\Application\Weather\GetWeather;

use Look\Application\Weather\GetWeather\Interface\GetWeatherResponseInterface;
use Look\Domain\Weather\Interface\WeatherInterface;

class GetWeatherResponse implements GetWeatherResponseInterface
{
    public function __construct(
        protected bool $success,
        protected string $error,
        protected ?WeatherInterface $weather = null
    ) {
    }

    public function getWeather(): ?WeatherInterface
    {
        return $this->weather;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
