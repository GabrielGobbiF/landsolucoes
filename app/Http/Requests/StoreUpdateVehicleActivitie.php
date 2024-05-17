<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateVehicleActivitie extends FormRequest
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

        $ultimaKM = Request::input('ultimaKM');

        $rules = [
            'title' => 'required',
            'km_start' => [ 'required','gt:'.$ultimaKM],
        ];

        if ($this->method() == 'PUT') {
            //$rules['km_end'] = "required|regex:/^\d+(\.\d{1,2})?$/";
        }

        if(Request::input('title') == 'abastecimento' && $this->method() == 'POST'){
            $rules['image'] = ['required', 'image'];
        }

        return $rules;
    }
}
