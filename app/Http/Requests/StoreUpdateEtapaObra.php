<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateEtapaObra extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            //'meta_etapa' => "nullable|after:today|date_format:d/m/Y",
            'prazo_atendimento' => "nullable|numeric",
            'data_abertura' => "nullable|date_format:d/m/Y",
            'nota_numero' => "nullable|numeric",
        ];

        return $rules;
    }
}
