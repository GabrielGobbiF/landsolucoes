<?php

namespace App\Http\Requests\Comercial;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Validator as Validator;

class UpdateData extends FormRequest
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
        $id = $this->segment(3);

        $rules = [
            'razao_social' => ['required'],
            'client_id' => ['required'],
            'service_id' => ['required'],
            'concessionaria_id' => ['required'],

            'requester' => ['required'],
            'requester_email' => ['required'],
            'requester_phone' => ['required'],
        ];

        return $rules;
    }
}
