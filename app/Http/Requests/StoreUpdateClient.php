<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Validator as Validator;

class StoreUpdateClient extends FormRequest
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

        Validator::extend('cnpj_unique', function ($attribute, $value, $parameters, $validator) use ($uuid) {
            $value = str_replace(['.', ',', '/', '-'], '', $value); // tranformar input no mesmo formato que pode estar na BD
            return Client::where('cnpj', $value)->where('uuid', '<>', $uuid)->count() == 0; // verificar se já existe
        });

        $rules = [
            'company_name' => "required|min:3|max:255",
            'username' => "required|min:3|max:255|unique:clients,username,{$uuid},uuid",
            'cnpj' => "nullable|min:3|max:255|cnpj_unique|unique:clients,cnpj,{$uuid},uuid",
        ];

        return $rules;
    }
}
