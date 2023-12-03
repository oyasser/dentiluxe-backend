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


use Modules\User\Http\Controllers\Auth\LoginController;
use Modules\User\Http\Controllers\Auth\NewPasswordController;
use Modules\User\Http\Controllers\Auth\PasswordResetLinkController;
use Modules\User\Http\Controllers\Auth\RegisterController;
use Modules\User\Http\Controllers\UserController;

Route::post('/login', [LoginController::class, 'login']);

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/forgot-password', [PasswordResetLinkController::class, 'sendResetLink'])->middleware('guest');

Route::post('/reset-password/{token}', [PasswordResetLinkController::class, 'generateResetURL'])->middleware('guest')->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'resetPassword'])->middleware('guest');

Route::middleware(['auth:admins'])
    ->controller(UserController::class)
    ->prefix('admin')
    ->group(callback: function () {

        Route::get('/users', 'index');
        Route::get('/users/{user}', 'show');

    });

Route::middleware(['auth:api'])
    ->controller(UserController::class)
    ->group(callback: function () {
        Route::get('profile', 'profile');
        Route::patch('profile', 'updateProfile');
        Route::patch('password', 'changePassword');
        Route::get('orders', 'orders');
        Route::get('orders/{number}', 'order');
    });

