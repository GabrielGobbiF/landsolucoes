<?php

namespace App\Jobs\Etapas;

use App\Mail\ComercialStatusReminder;
use App\Managers\ApiBrasil\ApiBrasil;
use App\Models\Obra;
use App\Supports\Enums\Comercial\ComercialStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMessageCheckFaturamento implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app(ApiBrasil::class)->sendEtapaCheckFaturamento();
    }
}
