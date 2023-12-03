<?php

use Modules\PromoCode\Http\Controllers\PromoCodeController;

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
    ->controller(PromoCodeController::class)
    ->prefix('admin/promocodes')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{code}', 'show');
        Route::patch('/{code}', 'update');
        Route::patch('/{code}/expire', 'expire');
    });

Route::controller(PromoCodeController::class)
    ->prefix('promocodes')
    ->group(callback: function () {
        Route::get('/{code}/validate', 'validate');
        Route::get('/{code}/discount', 'discount');
    });
