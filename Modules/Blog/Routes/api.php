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

use Modules\Blog\Http\Controllers\BlogController;

Route::middleware(['auth:admins'])
    ->controller(BlogController::class)
    ->prefix('admin/blogs')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{blog}', 'show');
        Route::patch('/{blog}', 'update');
    });

Route::controller(BlogController::class)
    ->prefix('blogs')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::get('/{blog}', 'show');
    });
