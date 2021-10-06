<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Resources\EtapasFaturamento;
use App\Models\Comment;
use App\Models\Etapa;
use App\Models\EtapasFaturamento as ModelsEtapasFaturamento;
use App\Models\Obra;
use App\Models\ObraEtapa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseController extends Controller
{

    protected $search;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function global()
    {
        return view('pages.painel._partials.global');
    }

    public function global_search(Request $request)
    {
        $response = [];
        $search = $request->input('search');

        if ($search) {

            $comentario = new Comment();
            $comentarios = $this->getBuilder($comentario, $search, ['obs_texto', 'etapa_id', 'id']);

            foreach ($comentarios as $comentario) {
                $etapa = ObraEtapa::where('id', $comentario->etapa_id)->first();
                if($etapa){
                    $obra = Obra::where('id', $etapa->id_obra)->first();
                    $response['comentarios'][] = [
                        'descricao' => limit(Str::of($comentario->obs_texto), 70),
                        'route' => route('obras.show', [$etapa->id_obra, 'etp=' . $etapa->id])
                    ];

                }
            }

            $obra = new Obra();
            $obras = $this->getBuilder($obra, $search, ['razao_social', 'last_note', 'id']);

            foreach ($obras as $obra) {
                $response['obras'][] = [
                    'descricao' => Str::of($obra->razao_social)->append(' - Nº nota: ' . $obra->last_note),
                    'route' => route('obras.show', $obra->id)
                ];
            }

            $etapa = new ObraEtapa();
            $etapas = $this->getBuilder($etapa, $search, ['nota_numero', 'nome', 'id', 'id_obra']);

            foreach ($etapas as $etapa) {
                $response['obras Etapas'][] = [
                    'descricao' => Str::of($etapa->nome)->append(' - Nº nota: ' . $etapa->nota_numero),
                    'route' => route('obras.show', [$etapa->id_obra, 'etp=' . $etapa->id])
                ];
            }

            $etapaFaturamento = new ModelsEtapasFaturamento();
            $etapaFaturamentos = $this->getBuilder($etapaFaturamento, $search, ['id', 'coluna_faturamento', 'nf_n', 'status', 'obra_id', 'obr_etp_financerio_id']);

            foreach ($etapaFaturamentos as $etapaFaturamento) {
                $obra = $etapaFaturamento->obra;
                if (isset($obra) && $obra->status == 'aprovada') {
                    $response['Faturamento'][] = [
                        'descricao' => Str::of('Obra: ' . $obra->razao_social . ' - ')->append($etapaFaturamento->coluna_faturamento)->append(' - NFN: ' . $etapaFaturamento->nf_n),
                        'route' => route('obras.finance', [$obra->id, 'etp=' . $etapaFaturamento->obr_etp_financerio_id])
                    ];
                }
            }
        } else {
            $response = [];
        }

        $returnHTML = view('pages.painel._partials.global')
            ->with('response', collect($response))
            ->render();

        return response()->json($returnHTML  ?? [], 200);
    }

    private function getBuilder(Model $model, $search, $get)
    {
        $this->search = $search;

        $searchColumns = method_exists($model, 'getSearchColumns')
            ? $model->getSearchColumns()
            : $model->getFillable();

        $model = $model
            ->where(function ($query) use ($searchColumns) {
                $search = $this->search;
                if ($search != '' && !is_null($searchColumns)) {
                    foreach ($searchColumns as $searchColumn) {
                        $query->Orwhere($searchColumn, 'LIKE', "%$search%");
                    }
                }
            });



        #dd([$model->toSql(), $model->getBindings()]);

        return  $model->get($get);
    }
}
