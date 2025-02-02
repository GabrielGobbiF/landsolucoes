<?php

namespace App\Services\Rdse;

use App\Models\RSDE\Handswork;
use App\Models\RSDE\Rdse;
use App\Models\RSDE\RdseActivity;
use App\Models\RSDE\RdseActivityItens;
use App\Repositories\TableRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RdseService
{
    public function __construct() {}

    public function adicionarAtividade(Request $request, Rdse $rdse)
    {
        $request->validate([
            'equipe_id' => 'required',
            'veiculo_id' => 'required',
            'supervisor_id' => 'required',
            'encarregado_id' => 'required',
            //'diretoria' => 'required',
            'status_execution' => 'required',
            'atividades' => 'required',
            'data' => 'required',
            'inicio' => 'required|date_format:H:i',
            'fim' => 'required|date_format:H:i',
            'executado' => 'nullable',
            'civil' => 'required|boolean',
        ]);

        $data = [
            'rdse_id' => $rdse->id,
            'equipe_id' => $request->input('equipe_id'),
            'veiculo_id' => $request->input('veiculo_id'),
            'supervisor_id' => $request->input('supervisor_id'),
            'encarregado_id' => $request->input('encarregado_id'),
            'data' => $request->input('data'),
            'data_inicio' => $request->input('inicio'),
            'data_fim' => $request->input('fim'),
            'atividade_descricao' => $request->input('status_execution'),
            //'diretoria' => $request->input('diretoria'),
            'atividades' => $request->input('atividades'),
            'civil' => $request->input('civil'),
        ];

        $data['execucao'] = $request->input('executado', null) == 'false' ?  null : now();

        return RdseActivity::create($data);

        /*
        foreach ($request->input('itens') as $item) {

            #$description = Handswork::where('id', $item['id'])->dd()?->description;

            RdseActivityItens::create([
                'rdse_atividade_id' => $rdseAtividade->id,
                'rdse_id' => $rdse->id,
                'handsworks_id' => $item['id'],
                'description' => $item['id'],
            ]);
        }
        */

    }

    public function atualizarAtividade(Request $request, RdseActivity $rdseAtividade)
    {
        $request->validate([
            'equipe_id' => 'required',
            'veiculo_id' => 'required',
            'supervisor_id' => 'required',
            'encarregado_id' => 'required',
            //'diretoria' => 'required',
            'status_execution' => 'required',
            'atividades' => 'required',
            'data' => 'required',
            'inicio' => 'required|date_format:H:i',
            'fim' => 'required|date_format:H:i',
            'executado' => 'nullable',
            'civil' => 'required|boolean',
        ]);

        throw_if(
            !$rdseAtividade->canUpdate(),
            ValidationException::withMessages(['message' => 'Não é Possivel Atualizar ja Executado'])
        );

        $data = [
            'equipe_id' => $request->input('equipe_id'),
            'veiculo_id' => $request->input('veiculo_id'),
            'supervisor_id' => $request->input('supervisor_id'),
            'encarregado_id' => $request->input('encarregado_id'),
            'data' => $request->input('data'),
            'data_inicio' => $request->input('inicio'),
            'data_fim' => $request->input('fim'),
            'atividade_descricao' => $request->input('status_execution'),
            'atividades' => $request->input('atividades'),
            //'diretoria' => $request->input('diretoria'),
            'civil' => $request->input('civil'),
        ];

        $data['execucao'] = $request->input('executado', null) == 'false' ?  null : now();

        $rdseAtividade->update($data);

        /*
        $rdseAtividade->atividades()->delete();

        foreach ($request->input('itens') as $item) {
            RdseActivityItens::create([
                'rdse_atividade_id' => $rdseAtividade->id,
                'rdse_id' => $rdseAtividade->rdse_id,
                'handsworks_id' => $item['id'],
                'description' => $item['id'],
            ]);
        }
        */

        return;
    }
}
