<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterVisitorPortaria extends FormRequest
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
        return [
            'controlador' => ['required'],
            'veiculo_placa' => ['required'],
            'veiculo_nome' => ['required'],
            'motorista' => ['required'],
            'type' => ['required'],
            'observations' => ['nullable'],
            'attachments' => ['nullable'],
            'finality' => ['required'],
            'veiculo_tipo' => ['required'],
        ];
    }
}
