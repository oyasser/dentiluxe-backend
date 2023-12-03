<?php

use Modules\Slider\Http\Controllers\SliderController;

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
    ->controller(SliderController::class)
    ->prefix('admin/sliders')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{slider}', 'show');
        Route::patch('/{slider}', 'update');
    });

Route::controller(SliderController::class)
    ->prefix('sliders')
    ->group(callback: function () {

        Route::get('/', 'index');
        Route::get('/{slider}', 'show');

    });
