<?php

declare(strict_types=1);

namespace Look\Application\Weather\GetWeatherMenu\Interface;

use Look\Domain\TimeOfDay\TimeOfDay;

interface GetWeatherMenuResponseInterface
{
    /**
     * @return TimeOfDay[]
     */
    public function getMenu(): array;
}
