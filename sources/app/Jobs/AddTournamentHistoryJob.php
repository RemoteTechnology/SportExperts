<?php

namespace App\Jobs;

use App\Models\TournamentAdmin;
use App\Repository\TournamentHistoryActionRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddTournamentHistoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $attributes;
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admin = TournamentAdmin::where([
            FIELD_TOURNAMENT_ID         => $this->attributes[FIELD_TOURNAMENT_ID],
            FIELD_USER_ID               => $this->attributes[FIELD_TOURNAMENT_ADMIN_ID],
            ])->first();
        $tournamentHistoryActionRepository = new TournamentHistoryActionRepository();
        $tournamentHistoryActionRepository->store([
            FIELD_TOURNAMENT_ID         => $this->attributes[FIELD_TOURNAMENT_ID],
            FIELD_TOURNAMENT_ADMIN_ID   => $admin->id,
            FIELD_STATUS                => $this->attributes[FIELD_STATUS],
            FIELD_DESCRIPTION           => $this->attributes[FIELD_DESCRIPTION],
            FIELD_CURRENT_DATE          => $this->attributes[FIELD_CURRENT_DATE],
            FIELD_CURRENT_TIME          => $this->attributes[FIELD_CURRENT_TIME],
        ]);
    }
}
