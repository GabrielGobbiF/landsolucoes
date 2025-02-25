<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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
            'prazo_atendimento' => "nullable",
            'data_abertura' => "nullable",
            'nota_numero' => "nullable|numeric",
        ];

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $array = [
            'data_abertura' => $this->validateDate($this->data_abertura),
            'meta_etapa' => $this->validateDate($this->meta_etapa),
            'data_programada' => $this->validateDate($this->data_programada),
            'data_iniciada' => $this->validateDate($this->data_iniciada),
            'data_pedido' => $this->validateDate($this->data_pedido),
            'data_prazo_total' => $this->validateDate($this->data_prazo_total),
            'prazo_atendimento' => intVal(only_numbers($this->prazo_atendimento)),
        ];

        $this->merge($array);
    }

    private function validateDate($date, $col = null)
    {
        if (!$date) {
            return null;
        }

        $validate = str_contains($date, '/') ? 'd/m/Y' : 'Y-m-d';

        throw_if(
            !validateDate($date, $validate),
            ValidationException::withMessages([$col ?? null => 'Por favor digite uma data válida'])
        );

        return date_format(Carbon::parse(str_replace('/', '-', $date)), 'Y-m-d');
    }
}
