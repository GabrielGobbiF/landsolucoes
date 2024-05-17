<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PasswordExpiredRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $uuid = Auth::user()->id;

        $rules = [
            'password' => ['required', 'min:6', 'max:20', 'confirmed'],
        ];

        if (Auth::user()->rg == '') {
            $rules['rg'] = ['required', "unique:users,rg,{$uuid},id"];
        }

        return $rules;
    }
}
