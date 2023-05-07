<?php

declare(strict_types=1);

namespace Look\Infrastructure\Gateway\Weather;

use Illuminate\Support\Facades\Http;
use Look\Application\Builder\Exception\NoRequiredPropertiesException;
use Look\Domain\GeoLocation\Interface\GeoLocationBuilderInterface;
use Look\Domain\GeoLocation\Interface\GeoLocationInterface;
use Look\Domain\TimeOfDay\TimeOfDay;
use Look\Domain\Value\Exception\InvalidValueException;
use Look\Domain\Weather\Exception\GetWeatherException;
use Look\Domain\Weather\Interface\WeatherBuilderInterface;
use Look\Domain\Weather\Interface\WeatherCacheInterface;
use Look\Domain\Weather\Interface\WeatherGatewayInterface;
use Look\Domain\Weather\Interface\WeatherInterface;
use Psr\Log\LoggerInterface;

class WeatherGateway implements WeatherGatewayInterface
{
    protected string $url = 'https://api.weather.yandex.ru/v2/forecast';

    public function __construct(
        protected string                      $token,
        protected WeatherBuilderInterface     $weatherBuilder,
        protected GeoLocationBuilderInterface $geoLocationBuilder,
        protected WeatherCacheInterface       $weatherCache,
        protected LoggerInterface             $logger
    ) {
    }

    public function getWeather(GeoLocationInterface $geoLocation, TimeOfDay $timeOfDay): WeatherInterface
    {
        $params = ['lon' => $geoLocation->getLon()->getValue(), 'lat' => $geoLocation->getLat()->getValue()];
        $response = $this->weatherCache->getWeather($geoLocation, function () use ($params) {
            return $this->executeRequest($params);
        });

        try {
            return $this->makeEntity($response, $timeOfDay);
        } catch (InvalidValueException|NoRequiredPropertiesException $exception) {
            $this->logger->emergency('Не удалось создать сущность погоды', [
                'exception' => $exception,
                'params' => $params
            ]);

            throw new GetWeatherException('Не удалось создать сущность погоды');
        }
    }

    /**
     * @throws InvalidValueException|NoRequiredPropertiesException
     * @throws GetWeatherException
     */
    protected function makeEntity(array $params, TimeOfDay $timeOfDay): WeatherInterface
    {
        $date = $timeOfDay->getDate()->format('Y-m-d');
        $hours = $timeOfDay->getHourDiapason();

        foreach ($params['forecasts'] as $forecast) {
            if ($forecast['date'] !== $date) {
                continue;
            }

            $temperatures = [];

            foreach ($forecast['hours'] as $hour => $item) {
                if (in_array($hour, $hours, true)) {
                    $temperatures[] = $item['temp'];
                }
            }

            $address = sprintf(
                '%s, %s, %s',
                $params['geo_object']['locality']['name'],
                $params['geo_object']['province']['name'],
                $params['geo_object']['country']['name']
            );

            $geoLocation = $this->geoLocationBuilder
                ->setLat($params['info']['lat'])
                ->setLon($params['info']['lon'])
                ->setAddress($address)
                ->make();

            return $this->weatherBuilder
                ->setGeoLocation($geoLocation)
                ->setTemperature((int) round(array_sum($temperatures) / count($temperatures)))
                ->setMinTemperature(min($temperatures))
                ->setMaxTemperature(max($temperatures))
                ->make();
        }

        throw new GetWeatherException("Погода для даты $date не найдена");
    }

    /**
     * @throws GetWeatherException
     */
    protected function executeRequest(array $params): array
    {
        $headers = ['X-Yandex-API-Key' => $this->token];
        $this->prepareParams($params);

        $response = Http::withHeaders($headers)->get($this->url, $params);

        if ($response->status() === 404) {
            throw new GetWeatherException($response->body());
        }

        return $response->json();
    }

    protected function prepareParams(array &$params): void
    {
        if (!isset($params['lang'])) {
            $params['lang'] = 'ru_RU';
        }
    }
}
