<?php

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

use Modules\Dashboard\Http\Controllers\DashboardController;

Route::controller(DashboardController::class)->middleware(['auth:admins'])
    ->prefix('admin/dashboard')
    ->group(callback: function () {
        Route::get('/', 'statistics');
    });
