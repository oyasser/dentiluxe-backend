<?php

use Modules\Tag\Http\Controllers\TagController;

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
    ->controller(TagController::class)
    ->prefix('admin/tags')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{tag}', 'show');
        Route::patch('/{tag}', 'update');
    });

Route::controller(TagController::class)
    ->prefix('tags')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::get('/{tag}', 'show');
        Route::get('/{tag}/items', 'items');
    });
