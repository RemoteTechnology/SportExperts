<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function () {
    Route::post('create', [UserController::class, 'create'])
        ->name('user.create');
    Route::prefix('auth')->group(function () {
        Route::post('/', [UserController::class, 'auth'])
            ->name('user.auth');
        // Vk Авторизация
//        Route::post('callback', [UserController::class, 'authSocialCallback'])
//            ->name('user.auth');
//        Route::post('callback', [UserController::class, 'authSocialCallback'])
//            ->name('user.auth');
        // Google Авторизация
//        Route::post('callback', [UserController::class, 'authSocialCallback'])
//            ->name('user.auth');
//        Route::post('callback', [UserController::class, 'authSocialCallback'])
//            ->name('user.auth');
    });
    Route::get('logout', [UserController::class, 'logout'])
        ->middleware('auth')
        ->name('user.logout');
    Route::get('show', [UserController::class, 'show'])
        ->name('user.show');
});
