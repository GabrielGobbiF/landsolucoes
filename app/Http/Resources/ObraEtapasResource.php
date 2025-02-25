<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Console\Helper\Helper;

class ObraEtapasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $prazo = null;
        if ($this->check != 'C') {
            if (($this->data_abertura != '' || $this->data_iniciada != '') && ($this->prazo_atendimento != '' || $this->tempo_atividade)) {
                $prazo = $this->checkPrazo();
            }
        }

        $data = [
            "search" => $this->nome . $this->id,

            "id" => $this->id,
            "name" => limit($this->nome, 50),
            "observacao" => $this->observacao,
            "n_nota" => $this->nota_numero ?? 0,
            "meta_etapa" => $this->meta_etapa != '' ? $this->meta_etapa : '',
            "data_abertura" => $this->data_abertura != '' ? $this->data_abertura : NULL,
            "data_programada" => $this->data_programada != '' ? $this->data_programada : NULL,
            "data_iniciada" => $this->data_iniciada != '' ? $this->data_iniciada : NULL,
            "data_prazo_total" => $this->data_prazo_total != '' ? $this->data_prazo_total : NULL,
            "data_pedido" => $this->data_pedido != '' ? $this->data_pedido : NULL,
            "prazo_atendimento" => $this->prazo_atendimento,
            "data_prazo_total" => $this->data_prazo_total,
            "check" => $this->check,
            "responsavel" => $this->responsavel,
            "cliente_responsavel" => $this->cliente_responsavel,
            "preco" => $this->preco,
            "quantidade" => $this->quantidade,
            "unidade" => $this->unidade,
            "tempo_atividade" => $this->tempo_atividade,
            "tipo" => $this->tipo ? $this->tipo->slug : null,
            "tipo_id" => $this->tipo_id,
            "prazo" => isset($prazo) ? $prazo : '',
            "comments" => $this->getComments(),
            "finance" => $this->etapaFinanceiro($this->id_obra),
            "activities" => LogResource::collection($this->activities->sortByDesc('id')),
            'haveDocuments' => $this->files->count() > 0 ? true : false,
            'id_etapa' => $this->id_etapa
        ];

        return $data;
    }

    public function getComments()
    {
        $comment = Comment::where('etapa_id', $this->id)->orderby('id', 'DESC')->limit(1)->first(['obs_texto']);
        return $comment ? limit($comment->obs_texto, 30) : '';
    }

    public function checkPrazo()
    {
        $msg = 'Concluido';
        $check = 'success';
        $atraso = 'success';

        $in = $this->data_abertura != '' ? $this->data_abertura : $this->data_iniciada;
        $out = $this->prazo_atendimento != '' ? $this->prazo_atendimento : $this->tempo_atividade;

        $prazoTotal = somarData($out, $in);
        $date = Carbon::parse($prazoTotal);
        $dateP = Carbon::parse($prazoTotal)->format('Y-m-d');
        $now = Carbon::now()->format('Y-m-d');

        $msg = $date->diffForHumans($now, [
            'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
            'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS,
        ]);

        if ($now > $date) {
            $check = 'danger';
            $atraso = 'danger';
            $msg = 'Vencida: ' . $msg;
        } elseif ($now == $dateP) {
            $check = 'warning';
            $atraso = 'warning';
            $msg = 'Vence Hoje';
        } elseif ($now < $date) {
            $check = 'success';
        }

        return [
            'msg' => $msg,
            'check' => $check,
            'atraso' => $atraso
        ];

        #if($this->nome == 'Pedido do Custo de rede e Corrente de Curto Circuito'){
        #    dd($now);
        #}
    }

    public function buttons()
    {
        '<a type="button" class="btn btn-info" onclick="edit_etapa(591)"><i class="fas fa-edit"></i></a>
         <a class="btn btn-danger"> <i class="fas fa-trash"></i> </a>
        ';
    }
}
