<?php

namespace App\Console\Commands;

use App\Models\RSDE\Rdse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProgramacaoStatusAprVencida extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:programacao-status-apr-vencida';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $hoje = Carbon::now();

        $registrosVencidos = app("model-cache")->runDisabled(closure: function () use ($hoje) {
            return Rdse::select('n_order', 'id', 'apr_at', 'notify_at')
                ->where(function ($query) use ($hoje) {
                    $query->where('notify_at', '<>', $hoje);
                    $query->orWhere('notify_at', null);
                })
                ->where('apr_at', '<', $hoje)->limit(30)->get();
        });

        if ($registrosVencidos->isEmpty()) {
            $this->info('Nenhum registro vencido encontrado.');
            return 0;
        }

        $usersId = [1, 258, 259, 263, 264, 262];

        $users = User::whereIn('id', $usersId)->get();

        $service = new \App\Services\NotificationsExampleService();

        foreach ($registrosVencidos as $registroVencidos) {
            $route = route('rdse.programacao.show', $registroVencidos->id);

            $n_order = $registroVencidos->n_order;
            $apr_at = $registroVencidos->apr_at;
            $description = "$n_order - Status APR VENCIDA! - $apr_at";

            foreach ($users as $user) {
                $service->notifyUser($user, 'Programação', $description, 'danger', $route);
            }

            $registroVencidos->notify_at = $hoje;
            $registroVencidos->save();
        }
    }
}
