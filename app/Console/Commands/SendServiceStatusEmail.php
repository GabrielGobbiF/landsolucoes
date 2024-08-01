<?php

namespace App\Console\Commands;

use App\Mail\ComercialStatusReminder;
use Illuminate\Console\Command;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceStatusReminder;
use App\Models\Obra;
use App\Models\User;
use App\Supports\Enums\Comercial\ComercialStatus;

class SendServiceStatusEmail extends Command
{
    protected $signature = 'email:send-service-status';

    protected $description = 'Send reminder emails for services in "Elaboração" status';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Checking services with "Elaboração" status...');

        $obras = Obra::where('status', ComercialStatus::ELABORACAO)
            ->where(function ($query) {
                $query->whereDate('updated_at', '<', now()->subDays(4))
                    ->orWhereDate('last_reminder_sent_at', '<', now()->subDays(2))
                    ->orWhereNull('last_reminder_sent_at');
            })
            ->get();

        foreach ($obras as $obra) {
            $responsavelId = $obra->viabilizacao()->first()?->responsavel_id;

            if (!empty($responsavelId)) {
                $responsavel = User::where('id', $responsavelId)->first();

                if (!empty($responsavel->email)) {
                    $obra->setLog('email_reminder_elaboracao', User::where('username', 'marcos.varella')->first());

                    Mail::to($responsavel->email)->send(new ComercialStatusReminder($obra, $responsavel));
                    #$obra->last_reminder_sent_at = now();
                    #$obra->save();

                    $this->info("Email sent to: $responsavel->name");
                }
            }
        }

        $this->info('Reminder emails sent successfully.');
    }
}
