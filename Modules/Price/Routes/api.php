<?php

use Illuminate\Http\Request;
use Modules\Price\Http\Controllers\PriceController;

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


Route::middleware(['auth:admins'])
    ->controller(PriceController::class)
    ->prefix('admin/prices')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{price}', 'show');
        Route::patch('/{price}', 'update');
    });

Route::middleware(['auth:api'])
    ->controller(PriceController::class)
    ->prefix('prices')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::get('/{price}', 'show');
    });
