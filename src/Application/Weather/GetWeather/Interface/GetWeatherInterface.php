<?php

declare(strict_types=1);

namespace Look\Application\Weather\GetWeather\Interface;

interface GetWeatherInterface
{
    /**
     * @param GetWeatherRequestInterface $request
     * @return GetWeatherResponseInterface
     */
    public function getWeather(GetWeatherRequestInterface $request): GetWeatherResponseInterface;
}
