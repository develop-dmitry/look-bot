<?php

use App\Http\Controllers\ClothesController;
use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('telegram', [TelegramController::class, 'handle']);

Route::prefix('v1')->group(static function () {
    Route::prefix('clothes')->group(static function () {
        Route::post('/', [ClothesController::class, 'getClothes']);
        Route::post('choose', [ClothesController::class, 'chooseClothes']);
    });
});
