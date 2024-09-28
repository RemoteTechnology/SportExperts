<?php

namespace App\Jobs\MailQueue;

use App\Services\MailingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

require_once dirname(__DIR__, 2) . '/Domain/Constants/FieldConst.php';

class RegistrationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $attributes;
    private MailingService $mailingService;

    public function __construct(array $attributes, MailingService $mailingService)
    {
        $this->attributes = $attributes;
        $this->mailingService = $mailingService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->mailingService->mailNewUser([FIELD_EMAIL => $this->attributes[FIELD_EMAIL]]);
    }
}
