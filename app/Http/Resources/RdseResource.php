<?php

namespace App\Http\Resources;

use App\Models\TiposObra;
use Illuminate\Http\Resources\Json\JsonResource;

class RdseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $year = year();

        // Inicializa a variável para armazenar informações
        $p = '';
        $valorTotal = $this->getServicesTotal();

        // Calcula o valorUPS baseado na configuração
        $typeRdse = $this->type;
        $rdseConfig = collect(config("admin.rdse.type", []))->where('name', $typeRdse)->first();

        $valorUps = !empty($rdseConfig) ? $valorTotal['p'] / $rdseConfig['value'] : 0;

        // Verifica o status parcial e define o valor de 'p'
        if ($this->parcial_1) {
            $p = 'P2';
        }

        if ($this->parcial_2) {
            $p = 'P3';
        }

        if ($this->parcial_3) {
            $p = 'P4';
        }

        // Filtros vindos da requisição
        $filters = $request->get('filter', []);

        // Array principal de dados
        $data = [
            'id' => $this->id,
            'observations' => limit($this->observations, 30),
            'observations_not_limit' => $this->observations,
            'description' => ($this->description),
            'description_limit' => limit($this->description, 18),
            'n_order' => $this->n_order ?? '',
            'name' => $this->n_order ?? '',
            'search' => $this->n_order ?? '',
            'equipe' => $this->equipe,
            'solicitante' => $this->solicitante,
            'at' => !empty($this->at) ? return_format_date($this->at) : '',
            'type' => $this->type,
            'tipo_obra' => $this->tipo_obra,
            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),
            'valor_total' => "{$p} R$ " . maskPrice($valorTotal['p']),
            'valor' => 'R$ ' . maskPrice($valorTotal['total']),
            'valor_ups' => maskPrice($valorUps),
            'ups' => $valorUps,
            'status_execution' => $this->status_execution,
            'status_closing_label' => $this->status_closing->getLabelHTML(),
            'enel_deadline' => $this->enel_deadline,
            'viability_execution_date' => $this->viability_execution_date,
            'apr_at' => $this->apr_at,
            'work_start_date' => $this->work_start_date,
            'work_end_date' => $this->work_end_date,
            'apr_at_input' => $this->apr_at,
            'is_civil' => $this->is_civil,
            'sigeo' => $this->sigeo,
            'diretoria' => $this->diretoria,
            'sigeo_at' => $this->sigeo_at,
            'month' => monthByFormat($this->Month) . "/{$year}",
            'atividades' => "<a href='javascript:void(0)' onclick='openModaladdItemsModal(this)' data-id='{$this->id}' class='atividades'>
            {$this->getAtividadesDescriptionsAttribute($filters)}
        </a>",
        ];


        return $data;
    }

    private function getTipoObraSelect()
    {
        $tiposObra = TiposObra::all();

        $html = "<select id='select-tipo_obra' name='' class='form-control form-control-sm' onchange='updateStatusExecution(this, row.id)'>";
        foreach ($tiposObra as $item) {
            $html .= "<option value='" . $item->id . "' " . $item->id == $this->tipo_obra?->id ? 'selected' : null . "> " . $item->id . " </option>";
        }
        $html .= "</select>";

        return $html;
    }

    private function getStatusLabel()
    {
        return "<div class='badge badge-soft-" . $this->StatusLabel . " font-size-12'>
                " . __trans('rdses.status_label.' . $this->status) . "
            </div>";
    }

    private function getLabelStatusExecution() {}

    private function getValorTotalAndUps()
    {
        if ($this->parcial_1 == true) {
            $p = 'P2';
        }

        if ($this->parcial_2 == true) {
            $p = 'P3';
        }

        if ($this->parcial_3 == true) {
            $p = 'P4';
        }


        $result = [];
    }
}
