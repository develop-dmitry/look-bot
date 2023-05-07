<?php

declare(strict_types=1);

namespace Look\Application\Weather\GetWeather;

use Look\Application\Weather\GetWeather\Interface\GetWeatherInterface;
use Look\Application\Weather\GetWeather\Interface\GetWeatherRequestInterface;
use Look\Application\Weather\GetWeather\Interface\GetWeatherResponseInterface;
use Look\Domain\Weather\Exception\GetWeatherException;
use Look\Domain\Weather\Interface\WeatherGatewayInterface;
use Psr\Log\LoggerInterface;

class GetWeatherUseCase implements GetWeatherInterface
{
    public function __construct(
        protected WeatherGatewayInterface $weatherGateway,
        protected LoggerInterface $logger
    ) {
    }

    public function getWeather(GetWeatherRequestInterface $request): GetWeatherResponseInterface
    {
        try {
            $geoLocation = $request->getGeoLocation();
            $timeOfDay = $request->getTimeOfDay();
            $weather = $this->weatherGateway->getWeather($geoLocation, $timeOfDay);

            return new GetWeatherResponse(true, '', $weather);
        } catch (GetWeatherException $exception) {
            $this->logger->emergency('Не удалось получить прогноз погоды', [
                'geo_location' => [
                    'lat' => $geoLocation->getLat()->getValue(),
                    'lon' => $geoLocation->getLon()->getValue()
                ],
                'time_of_day' => [
                    'name' => $timeOfDay->getTimeOfDay(),
                    'date' => $timeOfDay->getDate()->format('Y-m-d')
                ],
                'exception' => $exception
            ]);

            return new GetWeatherResponse(false, 'Не удалось получить прогноз погоды');
        }
    }
}
