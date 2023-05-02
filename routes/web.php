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

Route::get('/test', function (\Look\Domain\Entity\Hair\Interface\HairRepositoryInterface $hairRepository, \Look\Domain\Entity\Clothes\Interface\ClothesRepositoryInterface $clothesRepository, \Look\Domain\Entity\Makeup\Interface\MakeupRepositoryInterface $makeupRepository, \Look\Domain\Entity\Look\Interface\LookRepositoryInterface $lookRepository, \Look\Infrastructure\Storage\Database\HairDatabaseStorage $hairDatabaseStorage) {
    \Illuminate\Support\Facades\Redis::set('test:223', '1');
    $redis = \Illuminate\Support\Facades\Redis::connection();
    $client = $redis->client();

    var_dump($client->keys('test:223'));
    var_dump($client->get('test:223'));
});
