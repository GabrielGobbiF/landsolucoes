<?php

namespace App\Console\Commands;

use App\Models\Obra;
use App\Models\ObraFinanceiro;
use App\Services\Etapas\FinanceiroService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateObraFinanceiro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'financeiro:update-obra
                            {--obra-id= : ID específico da obra para atualizar}
                            {--limit=100 : Limite de obras para processar por vez}
                            {--force : Forçar atualização mesmo se já foi atualizada hoje}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza os valores financeiros calculados para obras aprovadas';

    private FinanceiroService $financeiroService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FinanceiroService $financeiroService)
    {
        parent::__construct();
        $this->financeiroService = $financeiroService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Iniciando atualização dos valores financeiros das obras...');

        $obraId = $this->option('obra-id');
        $limit = (int) $this->option('limit');
        $force = $this->option('force');

        if ($obraId) {
            return $this->processarObraEspecifica($obraId);
        }

        return $this->processarTodasAsObras($limit, $force);
    }

    private function processarObraEspecifica($obraId)
    {
        $obra = Obra::find($obraId);

        if (!$obra) {
            $this->error("Obra com ID {$obraId} não encontrada.");
            return 1;
        }

        if (!$obra->financeiro) {
            $this->warn("Obra {$obraId} não possui registro financeiro. Criando...");
            $this->criarRegistroFinanceiro($obra);
        }

        $this->info("Processando obra {$obraId}: {$obra->razao_social}");

        if ($this->financeiroService->saveObraFinanceiro($obra->id)) {
            $obra->update(['financeiro_update' => now()]);
            $this->info("✅ Obra {$obraId} atualizada com sucesso!");
            return 0;
        } else {
            $this->error("❌ Erro ao atualizar obra {$obraId}");
            return 1;
        }
    }

    private function processarTodasAsObras($limit, $force)
    {
        $query = Obra::select('id', 'razao_social', 'financeiro_update')
            #->whereNull('remove_finance')
            #->whereNull('deleted_at')
            #->whereIn('status', ['aprovada'])
            ->whereHas('financeiro');

        if (!$force) {
            $hoje = Carbon::now()->startOfDay();
            $query->where(function($q) use ($hoje) {
                $q->whereNull('financeiro_update')
                  ->orWhereDate('financeiro_update', '<', $hoje);
            });
        }

        $total = $query->count();
        $obras = $query->limit($limit)->get();

        if ($obras->isEmpty()) {
            $this->info('Nenhuma obra encontrada para atualizar.');
            return 0;
        }

        $this->info("Encontradas {$total} obras para processar. Processando {$obras->count()} obras...");

        $bar = $this->output->createProgressBar($obras->count());
        $bar->start();

        $sucessos = 0;
        $erros = 0;

        foreach ($obras as $obra) {
            try {
                if ($this->financeiroService->saveObraFinanceiro($obra->id)) {
                    $obra->update(['financeiro_update' => now()]);
                    $sucessos++;
                } else {
                    $erros++;
                    $this->newLine();
                    $this->warn("Erro ao processar obra {$obra->id}: {$obra->razao_social}");
                }
            } catch (\Exception $e) {
                $erros++;
                $this->newLine();
                $this->error("Exceção na obra {$obra->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ Processamento concluído!");
        $this->info("   Sucessos: {$sucessos}");
        $this->info("   Erros: {$erros}");

        return $erros > 0 ? 1 : 0;
    }

    private function criarRegistroFinanceiro(Obra $obra)
    {
        ObraFinanceiro::create([
            'id_obra' => $obra->id,
            'valor_proposta' => 0,
            'valor_negociado' => 0,
            'valor_desconto' => 0,
            'valor_custo' => 0,
            'metodo_pagamento' => 'boleto',
        ]);
    }
}
