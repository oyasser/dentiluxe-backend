<?php

use Modules\Item\Http\Controllers\ItemController;

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
    ->controller(ItemController::class)
    ->prefix('admin/items')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{item}', 'show');
        Route::patch('/{item}', 'update');
    });

Route::controller(ItemController::class)
    ->prefix('items')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::get('/featured', 'featured');
        Route::get('/{item}', 'show');
        Route::get('/{item}/related', 'related');
    });
