<?php

use Modules\SalesOrder\Http\Controllers\SalesOrderController;

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
    ->controller(SalesOrderController::class)
    ->prefix('admin/orders')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::get('/{order}', 'show');
        Route::patch('/{order}', 'update');
    });

Route::post('/checkout', 'SalesOrderController@store');
