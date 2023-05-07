<?php

declare(strict_types=1);

namespace Look\Application\Weather\GetWeatherMenu;

use DateTime;
use Look\Application\Weather\GetWeatherMenu\Interface\GetWeatherMenuInterface;
use Look\Application\Weather\GetWeatherMenu\Interface\GetWeatherMenuResponseInterface;
use Look\Domain\TimeOfDay\TimeOfDay;

class TelegramGetWeatherMenuUseCase implements GetWeatherMenuInterface
{
    public function getWeatherMenu(): GetWeatherMenuResponseInterface
    {
        $timeOfDay = TimeOfDay::fromDateTime(new DateTime());
        $tomorrow = TimeOfDay::fromDateTime(new DateTime('tomorrow noon'));

        $result[] = $timeOfDay;

        foreach ($timeOfDay->getNexts() as $next) {
            $result[] = $next;
        }

        $result[] = $tomorrow;

        return new GetWeatherMenuResponse($result);
    }
}
