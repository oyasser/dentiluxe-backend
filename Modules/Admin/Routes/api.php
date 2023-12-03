<?php


use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\Auth\LoginController;
use Modules\Admin\Http\Controllers\Auth\NewPasswordController;
use Modules\Admin\Http\Controllers\Auth\PasswordResetLinkController;

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
Route::prefix('admin')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);

//    Route::post('/forgot-password', [PasswordResetLinkController::class, 'sendResetLink'])->middleware('guest');
//
//    Route::post('/reset-password/{token}', [PasswordResetLinkController::class, 'generateResetURL'])->middleware('guest')->name('password.reset');
//
//    Route::post('/reset-password', [NewPasswordController::class, 'resetPassword'])->middleware('guest');

    Route::middleware(['auth:admins'])->group(callback: function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('admins', 'index');
            Route::post('admins', 'store');
            Route::get('admins/{admin}', 'show');
            Route::patch('admins/{admin}', 'update');

            Route::get('profile', 'profile');
            Route::patch('profile', 'updateProfile');
            Route::patch('password', 'changePassword');
        });
    });
});
