<?php

use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvitedController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\TournamentController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/registration', [HomeController::class, 'registration']);
Route::get('/recovery', [HomeController::class, 'recovery']);

Route::prefix('profile')->group(function (){
    Route::get('/', [UserController::class, 'index']);
    Route::get('/settings', [UserController::class, 'settings']);
});

Route::prefix('event')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::get('/create', [EventController::class, 'create']);
    Route::get('/detail', [EventController::class, 'detail']);
    Route::get('/update', [EventController::class, 'update']);
    Route::get('/history', [EventController::class, 'history']);
});

Route::prefix('invite')->group(function (){
    Route::get('/', [InvitedController::class, 'index']);
    Route::get('/detail', [InvitedController::class, 'detail']);
});

Route::prefix('participant')->group(function () {
    Route::get('search', [ParticipantController::class, 'search']);
});

Route::prefix('tournament')->group(function () {
    Route::get('/', [TournamentController::class, 'index']);
    Route::get('/history', [TournamentController::class, 'history']);
});


Route::middleware(['auth'])->namespace('Admin')->prefix('admin')->group(function () {
    Route::get('', [SiteController::class, 'index']);
});
