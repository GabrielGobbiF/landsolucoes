<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEtapaFaturamento;
use App\Http\Resources\EtapasFinanceiroResource;
use App\Models\Obra;
use Illuminate\Http\Request;

class FinanceiroApiController extends Controller
{
    protected $repository, $obra;

    public function __construct(Obra $obra)
    {
        $this->obra = $obra;
    }

    public function show($obra_id, $etapa_id)
    {
        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        if (!$etapa = $obra->etapas_financeiro()->where('id', $etapa_id)->first()) {
            return response()->json('Object Etapa not found', 404);
        }

        return new EtapasFinanceiroResource($etapa);
    }

    public function storeFaturamento(StoreUpdateEtapaFaturamento $request, $obra_id, $etapa_id)
    {
        $columns = $request->all();

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        if (!$etapa = $obra->etapas_financeiro()->where('id', $etapa_id)->first()) {
            return response()->json('Object Etapa not found', 404);
        }

        $columns['user_id'] = auth()->user()->id;

        $faturamento = $etapa->faturamento()->get();
        $faturado = $faturamento->sum('valor') ?? 0;
        $aReceber = $etapa->valor_receber -  $faturado;

        if ($aReceber != 0) {
            $etapa->faturamento()->create($columns);
        } else {
            return redirect()
                ->route('obras.finance', [$obra->id, 'etp' => $etapa->id])
                ->with('message', 'o valor da etapa já foi faturado');
        }

        return redirect()
            ->route('obras.finance', [$obra->id, 'etp' => $etapa->id])
            ->with('message', 'Criado com sucesso');
    }

    public function updateStatus(Request $request, $obra_id, $etapa_id, $faturamento_id)
    {
        $check = $request->input('check');

        $check = $check == 'N' ? 'Y' : 'N';

        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return response()->json('Object Obra not found', 404);
        }

        if (!$etapa = $obra->etapas_financeiro()->where('id', $etapa_id)->first()) {
            return response()->json('Object Etapa not found', 404);
        }

        if (!$faturamento = $etapa->faturamento()->where('id', $faturamento_id)->first()) {
            return response()->json('Object Faturamento not found', 404);
        }

        $faturamento = $faturamento->update(['recebido_status' => $check]);

        return $etapa;
    }

    public function destroy(Request $request, $obra_id, $etapa_id, $faturamento_id)
    {
        if (!$obra = $this->obra->where('id', $obra_id)->first()) {
            return redirect()
                ->route('obras.index')
                ->with('error', 'Essa Obra não existe');
        }

        if (!$etapa = $obra->etapas_financeiro()->where('id', $etapa_id)->first()) {
            return redirect()
                ->route('obras.finance', [$obra->id])
                ->with('error', 'Essa Etapa não existe');
        }

        if (!$faturamento = $etapa->faturamento()->where('id', $faturamento_id)->first()) {
            return redirect()
                ->route('obras.finance', [$obra->id, 'etp' => $etapa->id])
                ->with('error', 'Esse faturamento não existe');
        }

        $faturamento->delete();

        return redirect()
            ->route('obras.finance', [$obra->id, 'etp' => $etapa->id])
            ->with('message', 'Deletado com sucesso');
    }
}
