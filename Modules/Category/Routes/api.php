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

use Modules\Category\Http\Controllers\CategoryController;

Route::middleware(['auth:admins'])
    ->controller(CategoryController::class)
    ->prefix('admin/categories')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{category}', 'show');
        Route::patch('/{category}', 'update');
        Route::get('/tree/list', 'listCategoryTree');
    });

Route::controller(CategoryController::class)
    ->prefix('categories')
    ->group(callback: function () {
        Route::get('/', 'index');
        Route::get('/{category}', 'show');
        Route::get('/{category}/items', 'items');
        Route::get('/tree/list', 'listCategoryTree');
    });
