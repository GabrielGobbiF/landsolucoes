<?php

namespace App\Jobs;

use App\Mail\ComercialStatusReminder;
use App\Models\Obra;
use App\Supports\Enums\Comercial\ComercialStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendComercialStatusEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        #$obras = Obra::where('status', ComercialStatus::ELABORACAO)
        #    ->where(function ($query) {
        #        $query->where('updated_at', '<', now()->subDays(4))
        #            ->orWhere('last_reminder_sent_at', '<', now()->subDays(2));
        #    })
        #    ->get();
#
        #foreach ($obras as $obra) {
        #    Mail::to('gabriel.gobbi15@gmail.com')->send(new ComercialStatusReminder($obra));
        #    $obra->last_reminder_sent_at = now();
        #    $obra->save();
        #}
    }
}
