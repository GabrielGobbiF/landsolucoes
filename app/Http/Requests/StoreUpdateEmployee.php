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
            'rg' => "required|unique:employees,rg,{$uuid},uuid",
            'ctps' => "required|unique:employees,ctps,{$uuid},uuid",
            'endereco' => "required|min:3|max:255",
            'cargo' => "required|min:3|max:255",
            'salario' => "required|max:15",
            'cnh_number' => "nullable",
            'date_contract' => ['required', 'date_format:d/m/Y'],
        ];
    }
}
