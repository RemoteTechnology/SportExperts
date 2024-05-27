<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [HomeController::class, 'login']);
Route::get('/registration', [HomeController::class, 'registration']);
Route::get('/recovery', [HomeController::class, 'recovery']);

Route::prefix('profile')->group(function (){
    Route::get('/', [UserController::class, 'index']);
    Route::get('/settings', [UserController::class, 'settings']);
});

