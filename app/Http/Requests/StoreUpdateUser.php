<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUpdateUser extends FormRequest
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
        $uuid = Auth::user()->uuid;

        $rules = [
            'name' => "required|min:3|max:255|unique:users,name,{$uuid},uuid",
            'username' => "required|min:3|max:255|unique:users,username,{$uuid},uuid",
            'email' => "required|min:3|email|max:255|unique:users,email,{$uuid},uuid",
            'password' => "required",
            'roles' => "required",
            "re" => ["nullable"],
        ];

        return $rules;
    }
}
