<?php

use App\Http\Procedures\V1\Authorizations\AuthByEmailProcedure;
use App\Http\Procedures\V1\Authorizations\AuthByGoogleProcedure;
use App\Http\Procedures\V1\Authorizations\AuthByVkontakteProcedure;
use App\Http\Procedures\V1\Authorizations\LogoutProcedure;
use App\Http\Procedures\V1\Events\EventDestroyProcedure;
use App\Http\Procedures\V1\Events\EventListProcedure;
use App\Http\Procedures\V1\Events\EventReadProcedure;
use App\Http\Procedures\V1\Events\EventStoreProcedure;
use App\Http\Procedures\V1\Events\EventUpdateProcedure;
use App\Http\Procedures\V1\Options\OptionDestroyProcedure;
use App\Http\Procedures\V1\Options\OptionListProcedure;
use App\Http\Procedures\V1\Options\OptionReadProcedure;
use App\Http\Procedures\V1\Options\OptionStoreProcedure;
use App\Http\Procedures\V1\Options\OptionUpdateProcedure;
use App\Http\Procedures\V1\Participants\ParticipantDestroyProcedure;
use App\Http\Procedures\V1\Participants\ParticipantListProcedure;
use App\Http\Procedures\V1\Participants\ParticipantReadProcedure;
use App\Http\Procedures\V1\Participants\ParticipantStoreProcedure;
use App\Http\Procedures\V1\Participants\ParticipantUpdateProcedure;
use App\Http\Procedures\V1\Teams\EventTeamDestroyProcedure;
use App\Http\Procedures\V1\Teams\EventTeamListProcedure;
use App\Http\Procedures\V1\Teams\EventTeamReadProcedure;
use App\Http\Procedures\V1\Teams\EventTeamStoreProcedure;
use App\Http\Procedures\V1\Teams\EventTeamUpdateProcedure;
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
        //// END V1 AUTH ENDPOINTS
        Route::rpc(ROUTE_DEFAULT, [UserRegistrationProcedure::class])->name('v1.user.registration');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_DEFAULT . 'logout', [LogoutProcedure::class])->name('v1.user.logout');
        });
    });
    //// END V1 USER ENDPOINTS

    //// V1 TEAM ENDPOINTS
    Route::prefix('team')->group(function () {
        Route::rpc(ROUTE_DEFAULT, [EventTeamListProcedure::class])->name('team.list');
        Route::rpc(ROUTE_DEFAULT . '/{id}', [EventTeamReadProcedure::class])->name('team.read');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_DEFAULT, [EventTeamStoreProcedure::class])->name('team.store');
            Route::rpc(ROUTE_DEFAULT, [EventTeamUpdateProcedure::class])->name('team.update');
            Route::rpc(ROUTE_DEFAULT . '/{id}', [EventTeamDestroyProcedure::class])->name('team.destroy');
        });
    });
    //// END V1 TEAM ENDPOINTS

    //// V1 EVENT ENDPOINTS
    Route::prefix('event')->group(function () {
        Route::rpc(ROUTE_DEFAULT, [EventListProcedure::class])->name('event.list');
        Route::rpc(ROUTE_DEFAULT . '/{id}', [EventReadProcedure::class])->name('event.read');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_DEFAULT, [EventStoreProcedure::class])->name('event.store');
            Route::rpc(ROUTE_DEFAULT, [EventUpdateProcedure::class])->name('event.update');
            Route::rpc(ROUTE_DEFAULT . '/{id}', [EventDestroyProcedure::class])->name('event.destroy');
        });
    });
    //// END V1 EVENT ENDPOINTS

    //// V1 PARTICIPANT ENDPOINTS
    Route::prefix('participant')->group(function () {
        Route::rpc(ROUTE_DEFAULT, [ParticipantListProcedure::class])->name('participant.list');
        Route::rpc(ROUTE_DEFAULT . '/{id}', [ParticipantReadProcedure::class])->name('participant.read');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_DEFAULT, [ParticipantStoreProcedure::class])->name('participant.store');
            Route::rpc(ROUTE_DEFAULT, [ParticipantUpdateProcedure::class])->name('participant.update');
            Route::rpc(ROUTE_DEFAULT . '/{id}', [ParticipantDestroyProcedure::class])->name('participant.destroy');
        });
    });
    //// END V1 PARTICIPANT ENDPOINTS

    //// V1 Option ENDPOINTS
    Route::prefix('option')->group(function () {
        Route::rpc(ROUTE_DEFAULT, [OptionListProcedure::class])->name('option.list');
        Route::rpc(ROUTE_DEFAULT . '/{id}', [OptionReadProcedure::class])->name('option.read');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_DEFAULT, [OptionStoreProcedure::class])->name('option.store');
            Route::rpc(ROUTE_DEFAULT, [OptionUpdateProcedure::class])->name('option.update');
            Route::rpc(ROUTE_DEFAULT . '/{id}', [OptionDestroyProcedure::class])->name('option.destroy');
        });
    });
    //// END V1 Option ENDPOINTS
});
