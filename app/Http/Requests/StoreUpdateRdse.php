<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRdse extends FormRequest
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
            'n_order' => "required|max:255|unique:rdses,n_order,{$id},id,modelo,0,deleted_at,null",
            'date_nfe_at' => 'nullable|date_format:d/m/Y',
            'month_date' => 'required'
        ];

        return $rules;
    }
}
