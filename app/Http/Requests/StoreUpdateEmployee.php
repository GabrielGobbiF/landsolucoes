<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateEmployee extends FormRequest
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

        $uuid = $this->segment(3);

        return [
            'name' => "required|min:3|max:255|unique:employees,name,{$uuid},uuid",
            'rg' => "required|digits:9|regex:/^\d+(\.\d{1,2})?$/",
            'ctps' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'email' => "required|min:3|max:255|unique:employees,email,{$uuid},uuid",

            'endereco' => "required|min:3|max:255",
            'estado_civil' => "required|min:3|max:255",
            'cargo' => "required|min:3|max:255",
            'salario' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'cnh' => ['required', 'in:0,1'],
        ];
    }
}
