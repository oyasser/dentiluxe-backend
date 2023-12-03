<?php

use Modules\Image\Http\Controllers\ImageController;

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
    ->controller(ImageController::class)
    ->prefix('admin/images')
    ->group(callback: function () {
        Route::delete('/{image}', 'destroy');
    });
