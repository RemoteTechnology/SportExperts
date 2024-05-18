<?php

use App\Http\Procedures\V1\Authorizations\AuthByEmailProcedure;
use App\Http\Procedures\V1\Authorizations\AuthByGoogleProcedure;
use App\Http\Procedures\V1\Authorizations\AuthByVkontakteProcedure;
use App\Http\Procedures\V1\Authorizations\LogoutProcedure;
use App\Http\Procedures\V1\Users\UserRegistrationProcedure;
use Illuminate\Support\Facades\Route;

require_once dirname(__DIR__) . '/app/Domain/Constants/RouteConst.php';
require_once dirname(__DIR__) . '/app/Domain/Constants/SocialConst.php';

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

//// V1 USER ENDPOINTS
Route::prefix('v1')->group(function () {
    //// V1 USER ENDPOINTS
    Route::prefix('user')->group(function () {
        Route::rpc(ROUTE_DEFAULT, [UserRegistrationProcedure::class])->name('v1.user.registration');

        //// V1 AUTH ENDPOINTS
        Route::prefix('auth')->group(function (){
            Route::rpc(ROUTE_DEFAULT, [AuthByEmailProcedure::class])->name('v1.user.auth.email');

            //// V1 AUTH SOCIAL ENDPOINTS
            Route::prefix('social')->group(function (){
                Route::rpc(ROUTE_DEFAULT . '{mode}', [AuthByVkontakteProcedure::class])->name('v1.user.auth.vkontakte');
                Route::rpc(ROUTE_DEFAULT . '{mode}', [AuthByGoogleProcedure::class])->name('v1.user.auth.google');
            });
            //// END V1 AUTH SOCIAL ENDPOINTS

        });
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_DEFAULT . 'logout', [LogoutProcedure::class])->name('v1.user.logout');
        });
        //// END V1 AUTH ENDPOINTS
    });
    //// END V1 USER ENDPOINTS

});
