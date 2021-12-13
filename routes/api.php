<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CurrencyConversionController;
use Illuminate\Http\Request;

use App\Http\Middleware\CheckUser;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => [CheckUser::class]], function () {
    Route::post('authenticate', [AuthenticateController::class, 'authenticate'])->middleware("cors");
    Route::post('getrates', [CurrencyConversionController::class, 'getRates'])->middleware("cors");
    Route::post('currencies', [CurrencyConversionController::class, 'getCurrencies'])->middleware("cors");
    Route::post('gethistorical', [CurrencyConversionController::class, 'getHistorical'])->middleware("cors");
});

Route::post('create', [AuthenticateController::class, 'create'])->middleware("cors");
