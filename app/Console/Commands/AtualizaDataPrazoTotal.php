<?php

namespace App\Console\Commands;

use App\Models\ObraEtapa;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AtualizaDataPrazoTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:atualiza-data-prazo-total';

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
        $obrasEtapas = ObraEtapa::whereNotNull('data_abertura')
            ->whereNotNull('prazo_atendimento')
            ->get();

        foreach ($obrasEtapas as $obraEtapa) {
            $data_abertura = Carbon::parse(str_replace('/', '-', $obraEtapa->data_abertura));
            $prazo_atendimento = $obraEtapa->prazo_atendimento;
            $data_prazo_total = $data_abertura->addDays($prazo_atendimento);

            $obraEtapa->data_prazo_total = $data_prazo_total;
            $obraEtapa->updateQuietly(['data_prazo_total' => $data_prazo_total]);
        }

        $this->info('Campo data_prazo_total atualizado com sucesso para todas as obrasEtapas.');
    }
}
