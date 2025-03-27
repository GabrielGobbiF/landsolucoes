<?php

namespace App\Console\Commands;

use App\Models\Obra;
use App\Services\Etapas\FinanceiroService;
use Illuminate\Console\Command;

class UpdateObraFinanceiro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-obra-financeiro';

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
        $obras = Obra::whereNull('financeiro_update')->select('id')->limit(10)->get();

        foreach ($obras as $obra) {
            app(FinanceiroService::class)->saveObraFinanceiro($obra->id);
            $obra->financeiro_update = now();
            $obra->save();
        }
    }
}
