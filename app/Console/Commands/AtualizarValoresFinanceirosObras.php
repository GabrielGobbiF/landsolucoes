<?php

namespace App\Console\Commands;

use App\Models\Obra;
use App\Services\Etapas\FinanceiroService;
use Illuminate\Console\Command;

class AtualizarValoresFinanceirosObras extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obras:atualizar-financeiro {--obra-id= : ID específico de uma obra}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza os valores de locação e compras de materiais de todas as obras';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(FinanceiroService $financeiroService)
    {
        $obraId = $this->option('obra-id');

        if ($obraId) {
            $this->info("Atualizando obra ID: {$obraId}");
            $this->atualizarObra($obraId, $financeiroService);
            $this->info("Obra {$obraId} atualizada com sucesso!");
            return 0;
        }

        $this->info('Iniciando atualização de valores financeiros das obras...');

        $totalObras = Obra::whereHas('financeiro')
            ->whereNull('remove_finance')
            ->whereNull('deleted_at')
            ->count();

        $this->info("Total de obras a processar: {$totalObras}");

        $bar = $this->output->createProgressBar($totalObras);
        $bar->start();

        $processadas = 0;
        $erros = 0;

        Obra::whereHas('financeiro')
            ->whereNull('remove_finance')
            ->whereNull('deleted_at')
            ->chunk(50, function ($obras) use ($financeiroService, $bar, &$processadas, &$erros) {
                foreach ($obras as $obra) {
                    try {
                        $this->atualizarObra($obra->id, $financeiroService);
                        $processadas++;
                    } catch (\Exception $e) {
                        $erros++;
                        $this->error("\nErro ao processar obra {$obra->id}: " . $e->getMessage());
                    }
                    $bar->advance();
                }
            });

        $bar->finish();
        $this->newLine(2);
        $this->info("Processamento concluído!");
        $this->info("Obras processadas com sucesso: {$processadas}");

        if ($erros > 0) {
            $this->warn("Obras com erro: {$erros}");
        }

        return 0;
    }

    private function atualizarObra($obraId, FinanceiroService $financeiroService)
    {
        $financeiroService->saveObraFinanceiro($obraId);
    }
}
