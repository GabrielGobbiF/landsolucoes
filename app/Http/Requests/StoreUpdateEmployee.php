<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
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
            'name' => "required|min:5|max:255|unique:employees,name,{$uuid},uuid",
            'rg' => "required|regex:/^\d+(\.\d{1,2})?$/|unique:employees,rg,{$uuid},uuid",
            'ctps' => "required|regex:/^\d+(\.\d{1,2})?$/|unique:employees,ctps,{$uuid},uuid",
            'email' => "required|min:3|max:255|unique:employees,email,{$uuid},uuid",
            'endereco' => "required|min:3|max:255",
            'estado_civil' => "required|min:3|max:255",
            'cargo' => "required|min:3|max:255",
            'salario' => "required|max:8|regex:/^\d+(\.\d{1,2})?$/",
            'cnh_number' => "nullable|regex:/^\d+(\.\d{1,2})?$/",
            'date_contract' => "required",
        ];
    }
}
