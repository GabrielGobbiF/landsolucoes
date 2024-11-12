<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;

class StoreUpdateInventory extends FormRequest
{

    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $id = $this->segment(4) ?? null;

        $rules = [
            'name' => ['required', 'string', 'max:255', Rule::unique('inventories')->ignore($id)->whereNull('deleted_at')],
            'code_omie' => ['nullable', "required", Rule::unique('inventories', 'code_omie')->ignore($id)->whereNull('deleted_at')],

            'sku' => ['nullable'],
            #'unit' => ['required'],
            #'length' => ['required'],
            #'width' => ['required'],
            #'height' => ['required'],
            #'weight' => ['required'],

            'opening_stock' => ['required'],
            'refueling_point' => ['required'],
            'market_price' => ['nullable'],
            'sale_price' => ['nullable'],
            'code_ncm' => ['nullable'],

            'sizes_to_upload' => [
                'nullable',
                'array',
            ],

            'sizes_to_upload.*' => [
                'string',
                'max:100',
            ],

            'files.*' => [
                'nullable',
                File::types(['png', 'jpg', 'jpeg'])->max(5 * 1024),
            ],
        ];

        if ($this->method() == 'PUT') {
            $rules['opening_stock'] = ['nullable'];
            $rules['refueling_point'] = ['nullable'];
            #$rules['market_price'] = ['nullable'];
            #$rules['sale_price'] = ['nullable'];
        }

        return $rules;
    }
}
