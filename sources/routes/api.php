<?php

use App\Http\Controllers\V1\Files\FileDestroyController;
use App\Http\Controllers\V1\Files\FileReadController;
use App\Http\Controllers\V1\Files\FileUploadController;
use App\Http\Procedures\V1\Authorizations\AuthByEmailProcedure;
use App\Http\Procedures\V1\Authorizations\AuthByGoogleProcedure;
use App\Http\Procedures\V1\Authorizations\AuthByVkontakteProcedure;
use App\Http\Procedures\V1\Authorizations\LogoutProcedure;
use App\Http\Procedures\V1\Events\Archive\ArchiveDestroyProcedure;
use App\Http\Procedures\V1\Events\Archive\ArchiveStoreProcedure;
use App\Http\Procedures\V1\Events\EventDestroyProcedure;
use App\Http\Procedures\V1\Events\EventListProcedure;
use App\Http\Procedures\V1\Events\EventReadProcedure;
use App\Http\Procedures\V1\Events\EventStoreProcedure;
use App\Http\Procedures\V1\Events\EventUpdateProcedure;
use App\Http\Procedures\V1\Events\Filter\EventDateFilterProcedure;
use App\Http\Procedures\V1\Events\Filter\EventOwnerFilterProcedure;
use App\Http\Procedures\V1\Inviteds\InvitedListProcedure;
use App\Http\Procedures\V1\Inviteds\InvitedReadProcedure;
use App\Http\Procedures\V1\Inviteds\InvitedReadUserParticipantProcedure;
use App\Http\Procedures\V1\Inviteds\InvitedStoreProcedure;
use App\Http\Procedures\V1\Inviteds\NotificationProcedure;
use App\Http\Procedures\V1\Logs\LogStoreProcedure;
use App\Http\Procedures\V1\Options\OptionDestroyProcedure;
use App\Http\Procedures\V1\Options\OptionListProcedure;
use App\Http\Procedures\V1\Options\OptionReadProcedure;
use App\Http\Procedures\V1\Options\OptionStoreProcedure;
use App\Http\Procedures\V1\Options\OptionUpdateProcedure;
use App\Http\Procedures\V1\Participants\Additionally\ParticipantDisqualificationProcedure;
use App\Http\Procedures\V1\Participants\Additionally\ParticipantSkippedProcedure;
use App\Http\Procedures\V1\Participants\Additionally\ParticipantКReplacementProcedure;
use App\Http\Procedures\V1\Participants\Filter\ParticipantOwnerFilterProcedure;
use App\Http\Procedures\V1\Participants\Filter\ParticipantUsersToEventFilterProcedure;
use App\Http\Procedures\V1\Participants\ParticipantDestroyProcedure;
use App\Http\Procedures\V1\Participants\ParticipantListProcedure;
use App\Http\Procedures\V1\Participants\ParticipantReadProcedure;
use App\Http\Procedures\V1\Participants\ParticipantStoreProcedure;
use App\Http\Procedures\V1\Participants\ParticipantUpdateProcedure;
use App\Http\Procedures\V1\Participants\Search\ParticipantSearchProcedure;
use App\Http\Procedures\V1\Teams\TeamDestroyProcedure;
use App\Http\Procedures\V1\Teams\TeamListProcedure;
use App\Http\Procedures\V1\Teams\TeamReadProcedure;
use App\Http\Procedures\V1\Teams\TeamStoreProcedure;
use App\Http\Procedures\V1\Teams\TeamUpdateProcedure;
use App\Http\Procedures\V1\Tournaments\Admin\TournamentAdminListProcedure;
use App\Http\Procedures\V1\Tournaments\TournamentReadProcedure;
use App\Http\Procedures\V1\Tournaments\Values\Filter\TournamentValueFreeParticipantsFilterProcedure;
use App\Http\Procedures\V1\Tournaments\Values\TournamentValueStoreProcedure;
use App\Http\Procedures\V1\Users\UserResetProcedure;
use App\Http\Procedures\V1\Users\UserReadProcedure;
use App\Http\Procedures\V1\Users\UserRegistrationProcedure;
use App\Http\Procedures\V1\Users\UserUpdateProcedure;
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

/**
 * @param string $className
 * @param string $method
 * @return string[]
 */
function operation(string $className, string $method='__invoke'): array
{
    return [$className, $method];
}

//// V1 USER ENDPOINTS
Route::prefix('v1')->group(function () {
    //// V1 LOGGING ENDPOINT
    Route::prefix('log')->group(function () {
        Route::rpc(ROUTE_STORE, [LogStoreProcedure::class])->name('v1.log.create');
//        Route::rpc(ROUTE_DEFAULT, [LogListProcedure::class])->name('v1.log.list');
    });
    //// END V1 LOGGING ENDPOINT

    //// V1 FILE ENDPOINTS
    Route::prefix('file')->group(function () {
        Route::get(ROUTE_DEFAULT, operation(FileReadController::class))->name('v1.file.read');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post(ROUTE_DEFAULT, operation(FileUploadController::class))->name('v1.file.uploaded');
            Route::delete(ROUTE_DEFAULT, operation(FileDestroyController::class))->name('v1.file.delete');
        });
    });
    //// END V1 FILE ENDPOINTS

    //// V1 USER ENDPOINTS
    Route::prefix('user')->group(function () {
        //// V1 AUTH ENDPOINTS
        Route::prefix('auth')->group(function (){
            Route::rpc(ROUTE_DEFAULT, [AuthByEmailProcedure::class])->name('v1.user.auth.email');
            //// V1 AUTH SOCIAL ENDPOINTS
            Route::prefix('social')->group(function (){
                Route::rpc(ROUTE_DEFAULT, [AuthByVkontakteProcedure::class])->name('v1.user.auth.vkontakte');
                Route::rpc(ROUTE_DEFAULT, [AuthByGoogleProcedure::class])->name('v1.user.auth.google');
            });
            //// END V1 AUTH SOCIAL ENDPOINTS
        });
        //// END V1 AUTH ENDPOINTS
        //TODO: передавать роль для приглашенных спортсменов
        Route::rpc(ROUTE_DEFAULT . 'registration', [UserRegistrationProcedure::class])->name('v1.user.registration');
        Route::rpc(ROUTE_READ, [UserReadProcedure::class])->name('v1.user.read');
        Route::rpc('reset', [UserResetProcedure::class])->name('v1.user.reset');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_UPDATE, [UserUpdateProcedure::class])->name('v1.user.update');
            Route::rpc(ROUTE_DEFAULT . 'logout', [LogoutProcedure::class])->name('v1.user.logout');
        });
    });
    //// END V1 USER ENDPOINTS

    //// V1 TEAM ENDPOINTS
    Route::prefix('team')->group(function () {
        Route::rpc(ROUTE_DEFAULT, [TeamListProcedure::class])->name('team.list');
        Route::rpc(ROUTE_READ, [TeamReadProcedure::class])->name('team.read');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_STORE, [TeamStoreProcedure::class])->name('team.store');
            Route::rpc(ROUTE_UPDATE, [TeamUpdateProcedure::class])->name('team.update');
            Route::rpc(ROUTE_DESTROY, [TeamDestroyProcedure::class])->name('team.destroy');
        });
    });
    //// END V1 TEAM ENDPOINTS

    //// V1 EVENT ENDPOINTS
    Route::prefix('event')->group(function () {
        Route::prefix('archive')->group(function () {
            Route::rpc(ROUTE_STORE, [ArchiveStoreProcedure::class])->name('event.archive.store');
            Route::rpc(ROUTE_DESTROY, [ArchiveDestroyProcedure::class])->name('event.archive.destroy');
        });
        Route::rpc(ROUTE_DEFAULT, [EventListProcedure::class])->name('event.list');
        Route::rpc(ROUTE_READ, [EventReadProcedure::class])->name('event.read');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_STORE, [EventStoreProcedure::class])->name('event.store');
            Route::rpc(ROUTE_UPDATE, [EventUpdateProcedure::class])->name('event.update');
            Route::rpc(ROUTE_DESTROY, [EventDestroyProcedure::class])->name('event.destroy');
        });
        Route::prefix(ROUTE_FILTER)->group(function () {
            Route::rpc(ROUTE_DEFAULT . '/participant/to/events', [EventDateFilterProcedure::class])->name('event.to.events.filter');
            Route::rpc(ROUTE_DEFAULT . '/my/events', [EventOwnerFilterProcedure::class])->name('event.my.events.filter');
        });
    });
    //// END V1 EVENT ENDPOINTS

    //// V1 PARTICIPANT ENDPOINTS
    Route::prefix('participant')->group(function () {
        Route::rpc(ROUTE_DEFAULT, [ParticipantListProcedure::class])->name('participant.list');
        Route::rpc(ROUTE_READ, [ParticipantReadProcedure::class])->name('participant.read');
        // TODO: разобраться с мидлварой для регистрации юзера
        Route::rpc(ROUTE_STORE, [ParticipantStoreProcedure::class])->name('participant.store');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_UPDATE, [ParticipantUpdateProcedure::class])->name('participant.update');
            Route::rpc(ROUTE_DESTROY, [ParticipantDestroyProcedure::class])->name('participant.destroy');
        });
        // TODO: эти процедуры мало чем относятся к "participant"
        Route::prefix('additionally')->group(function () {
            Route::rpc(ROUTE_DEFAULT . 'drop', [ParticipantDisqualificationProcedure::class])->name('participant.additionally.drop');
            Route::rpc(ROUTE_DEFAULT . 'replace', [ParticipantКReplacementProcedure::class])->name('participant.additionally.replace');
            Route::rpc(ROUTE_DEFAULT . 'skip', [ParticipantSkippedProcedure::class])->name('participant.additionally.skip');
        });
        Route::prefix('search')->group(function () {
            Route::rpc(ROUTE_DEFAULT, [ParticipantSearchProcedure::class])->name('participant.search');
        });
        Route::prefix(ROUTE_FILTER)->group(function () {
            Route::rpc(ROUTE_DEFAULT . '/events/my/participants', [ParticipantOwnerFilterProcedure::class])->name('participant.owner.filter');
            Route::rpc(ROUTE_DEFAULT . 'events/in/users', [ParticipantUsersToEventFilterProcedure::class])->name('participant.events.in.users.filter');
        });
    });
    //// END V1 PARTICIPANT ENDPOINTS

    //// V1 Option ENDPOINTS
    Route::prefix('option')->group(function () {
        Route::rpc(ROUTE_DEFAULT, [OptionListProcedure::class])->name('option.list');
        Route::rpc(ROUTE_READ, [OptionReadProcedure::class])->name('option.read');
        // TODO: разобраться с мидлварой для регистрации юзера
        Route::rpc(ROUTE_STORE, [OptionStoreProcedure::class])->name('option.store');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_UPDATE, [OptionUpdateProcedure::class])->name('option.update');
            Route::rpc(ROUTE_DESTROY, [OptionDestroyProcedure::class])->name('option.destroy');
        });
    });
    //// END V1 Option ENDPOINTS

    //// V1 Invite ENDPOINTS
    Route::prefix('invite')->group(function () {
        Route::rpc(ROUTE_DEFAULT, [InvitedListProcedure::class])->name('invite.list');
        Route::rpc(ROUTE_READ, [InvitedReadProcedure::class])->name('invite.read');
        Route::rpc(ROUTE_READ . '/participant', [InvitedReadUserParticipantProcedure::class])->name('invite.read.participant');
        // TODO: разобраться с мидлварой для регистрации юзера
        Route::rpc(ROUTE_STORE, [InvitedStoreProcedure::class])->name('invite.store');
        Route::middleware('auth:sanctum')->group(function () {
            Route::rpc(ROUTE_DEFAULT . 'notification', [NotificationProcedure::class])->name('invite.notification');
        });
    });
    //// END V1 Invite ENDPOINTS

    //// V1 Tournament ENDPOINTS
    Route::prefix('tournament')->group(function () {
        Route::rpc(ROUTE_READ, [TournamentReadProcedure::class])->name('tournament.read');

        //// V1 Tournament Admin ENDPOINTS
        Route::prefix('admin')->group(function (){
            Route::rpc(ROUTE_DEFAULT, [TournamentAdminListProcedure::class])->name('tournament.value.store');
        });
        //// END V1 Tournament Admin ENDPOINTS

        //// V1 Tournament Value ENDPOINTS
        Route::prefix('value')->group(function (){
            Route::middleware('auth:sanctum')->group(function () {
                Route::rpc(ROUTE_STORE, [TournamentValueStoreProcedure::class])->name('tournament.value.store');
                Route::prefix('filter')->group(function(){
                    Route::rpc(ROUTE_DEFAULT, [TournamentValueFreeParticipantsFilterProcedure::class])->name('tournament.value.filter');
                });
            });
        });
        //// END V1 Tournament Value ENDPOINTS
    });
    //// END V1 Tournament ENDPOINTS
});
