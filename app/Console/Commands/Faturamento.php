<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\VehicleActivities;
use App\Notifications\SendNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Faturamento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:carReview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar se o carro está com KM Multiplo de 10000';

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

        $faturamento = DB::select('select * from etapas_faturamentos WHERE data_vencimento < DATE_ADD(DATE_ADD(LAST_DAY(CURRENT_DATE), INTERVAL 1 DAY), INTERVAL 1 MONTH)', [1]);

        dd($faturamento);
    }
}
