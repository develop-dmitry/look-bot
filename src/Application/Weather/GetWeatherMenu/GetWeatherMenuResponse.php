<?php

declare(strict_types=1);

namespace Look\Application\Weather\GetWeatherMenu;

use Look\Application\Weather\GetWeatherMenu\Interface\GetWeatherMenuResponseInterface;
use Look\Domain\TimeOfDay\TimeOfDay;

class GetWeatherMenuResponse implements GetWeatherMenuResponseInterface
{
    /**
     * @param TimeOfDay[] $menu
     */
    public function __construct(
        protected array $menu
    ) {
    }

    public function getMenu(): array
    {
        return $this->menu;
    }
}
