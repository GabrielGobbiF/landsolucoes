<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterPortaria extends FormRequest
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
            'vehicle_id' => ['required'],
            'km' => ['required', 'gt:0'],
            'motorista_id' => ['required'],
            'type' => ['required'],
            'departamento' => ['required'],
            'observations' => ['nullable'],
            'attachments' => ['nullable'],
            'finality' => ['required'],
            'veiculo_tipo' => ['required'],
            'base' => ['required'],
            'rms' => ['nullable'],
        ];
    }
}
