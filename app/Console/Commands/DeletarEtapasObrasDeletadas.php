<?php

namespace App\Console\Commands;

use App\Models\Obra;
use Illuminate\Console\Command;

class DeletarEtapasObrasDeletadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deletar-etapas-obras-deletadas';

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
        $obrasDeletadas = Obra::onlyTrashed()->get();

        foreach ($obrasDeletadas as $obra) {
            $obra->etapas()->forceDelete();
        }

        $this->info('Etapas deletadas com sucesso para todas as obras deletadas.');
    }
}
