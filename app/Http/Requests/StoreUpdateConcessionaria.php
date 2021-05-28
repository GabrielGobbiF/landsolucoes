<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateConcessionaria extends FormRequest
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
        $slug = $this->segment(3);

        $rules = [
            'name' => "required|min:3|max:255|unique:concessionarias,name,{$slug},slug",
            'service' => "required",
        ];

        if ($this->method() == 'PUT') {
            $rules['service'] = ['nullable'];
        }

        return $rules;
    }
}
