<?php

use Illuminate\Http\Request;
use Modules\Currency\Http\Controllers\CurrencyController;

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
    ->controller(CurrencyController::class)
    ->prefix('admin/currencies')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{currency}', 'show');
        Route::patch('/{currency}', 'update');
    });

Route::middleware(['auth:api'])
    ->controller(CurrencyController::class)
    ->prefix('currencies')
    ->group(callback: function () {

        Route::get('/', 'index');
        Route::get('/{currency}', 'show');
    });
