<?php

namespace App\Http\Controllers\Admin\Form;

use App\Domain\Constants\EnumConstants\StatusLeadEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Events\Lead\LeadEventReadRequest;
use App\Repository\EventRepository;
use App\Repository\LeadRepository;
use App\Repository\TournamentAdminRepository;
use App\Repository\TournamentRepository;
use Carbon\Carbon;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class AllowEventFormController extends Controller
{
    private LeadRepository $leadRepository;
    private EventRepository $eventRepository;
    private TournamentRepository $tournamentRepository;
    private TournamentAdminRepository $tournamentAdminRepository;
    public function __construct(
        LeadRepository $leadRepository,
        EventRepository $eventRepository,
        TournamentRepository $tournamentRepository,
        TournamentAdminRepository $tournamentAdminRepository
    )
    {
        $this->leadRepository = $leadRepository;
        $this->eventRepository = $eventRepository;
        $this->tournamentRepository = $tournamentRepository;
        $this->tournamentAdminRepository = $tournamentAdminRepository;
    }


    public function __invoke(LeadEventReadRequest $request)
    {
        $attributes = $request->validated();
        $leadEvent = $this->leadRepository->findByKey($attributes['key']);

        try {
            $repository = $this->eventRepository->store($leadEvent['data']);
        } catch (UniqueConstraintViolationException) {
            return back()->with('error', 'Невозможно создать событие!');
        }

        if (!empty($repository)) {
            $this->leadRepository->updateStatus(
                $leadEvent['key'],
                StatusLeadEnum::PROCESSED,
                Carbon::now()->timestamp
            );
            define("DEFAULT_STAGE", 1);
            $tournamentRepository = $this->tournamentRepository->store([
                FIELD_KEY       => Str::uuid()->toString(),
                FIELD_EVENT_KEY => $repository->key,
                FIELD_STAGE     => DEFAULT_STAGE
            ]);

            if ($tournamentRepository) {
                $tournamentAdmin[FIELD_TOURNAMENT_ID] = $tournamentRepository->id;
                $tournamentAdmin[FIELD_USER_ID] = $repository->user_id;
                $this->tournamentAdminRepository->store($tournamentAdmin);
            }
            return back()->with('success', 'Событие создано!');
        }
        return back()->with('error', 'Невозможно создать событие!');
    }
}
