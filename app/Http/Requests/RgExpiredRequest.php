<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RgExpiredRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $uuid = Auth::user()->id;

        $rules['rg'] = ['required', "unique:users,rg,{$uuid},id"];

        return $rules;
    }
}
