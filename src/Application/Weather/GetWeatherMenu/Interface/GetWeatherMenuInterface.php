<?php

declare(strict_types=1);

namespace Look\Application\Weather\GetWeatherMenu\Interface;

interface GetWeatherMenuInterface
{
    public function getWeatherMenu(): GetWeatherMenuResponseInterface;
}
