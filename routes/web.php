<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/', function (\Look\Domain\Weather\Interface\WeatherGatewayInterface $weatherGateway, \Look\Domain\Client\Interface\ClientRepositoryInterface $clientRepository) {
    $geoLocation = (new \Look\Domain\GeoLocation\GeoLocation())
        ->setLat(new \Look\Domain\Value\Coordinate\Coordinate(54.193122))
        ->setLon(new Look\Domain\Value\Coordinate\Coordinate(37.617348));

    /*var_dump($weatherGateway->getWeather($geoLocation, \Look\Domain\TimeOfDay\TimeOfDay::fromTimeOfDay(\Look\Domain\TimeOfDay\TimeOfDay::Night)));*/

    /*$client = $clientRepository->getClientByTelegramId(668093623);

    var_dump($client);

    $geoLocation = (new \Look\Domain\GeoLocation\GeoLocation())
        ->setLat(new \Look\Domain\Value\Coordinate\Coordinate(54.193122))
        ->setLon(new Look\Domain\Value\Coordinate\Coordinate(37.617348));

    $client->setGeoLocation($geoLocation);

    $clientRepository->saveClient($client);

    var_dump($clientRepository->getClientByTelegramId(668093623));*/
});
