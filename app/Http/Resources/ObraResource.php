<?php

namespace App\Http\Resources;

use App\Models\Etapa;
use App\Models\ObraEtapa;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ObraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $progressEtapas = $this->getCountEtapas($this->id);

        return [
            "id" => $this->id,
            "razao_social" => limit($this->razao_social, 28),
            "clients.username" => $this->username,
            "client.concessionaria.service" => Str::of($this->username)->append(' - ' . $this->concessionaria_name)->append(' - ' . $this->service_name),
            "concessionaria_name" => $this->concessionaria_name,
            "concessionaria.service" => Str::of($this->concessionaria_name)->append(' - ' . $this->service_name),
            "service.name" => limit(__minusculo($this->service_name),30),
            "last_note" => $this->last_note,
            "updated_at" => formatDateAndTime($this->updated_at, 'd/m/Y'),
            "created_at" => formatDateAndTime($this->created_at),
            "progressEtapas" => $progressEtapas
        ];
    }

    public function getCountEtapas($idObra)
    {
        $html = '';

        $soma_etapa = 0;

        $etapas = ObraEtapa::where('id_obra', $idObra)->get();
        $etapas_concluidas = $etapas->where('check', 'C')->count();

        if ($etapas_concluidas != 0) {
            $soma = (100) / count($etapas);
            $soma_etapa = $soma * $etapas_concluidas;
        }

        $etapas = count($etapas);
        $soma_etapa = str_replace(',', '.', $soma_etapa);

        $html .= '<div class="d-grid">';
        if ($soma_etapa < '54.165823') {
            $html .= "  <span style='color: #000'> $etapas_concluidas / $etapas </span>";
        }
        $html .= '  <div class="progress">';
        $html .= "      <div class='progress-bar' role='progressbar' style='width: $soma_etapa%;' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'>";
        $html .= "          <span class='pd-5' style='color: #000'> $etapas_concluidas / $etapas </span>";
        $html .= '      </div>';
        $html .= '  </div>';
        $html .= '</div>';

        return $html;
    }
}
