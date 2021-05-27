<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator as Validator;

class StoreUpdateDepartment extends FormRequest
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

        $rules = [
            'company_name' => "required|min:3|max:255",
            'username' => "required|min:3|max:255|unique:clients,username,{$uuid},uuid",
            'cnpj' => "nullable|min:3|max:255|cnpj_unique|unique:clients,cnpj,{$uuid},uuid",
        ];

        return $rules;
    }
}
