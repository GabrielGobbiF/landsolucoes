<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $uuid = $this->segment(3);

        return [
            //'name' => "required|min:3|max:255|unique:users,name,{$uuid},uuid",
            //'email' => "required|min:3|email|max:255|unique:users,email,{$uuid},uuid",
            //'login' => "required|min:3|max:255|unique:users,login,{$uuid},uuid",
            //'rg' => "required|min:3|max:255|unique:users,rg,{$uuid},uuid",
            //'whatsapp' => "required|min:3|max:255|unique:users,whatsapp,{$uuid},uuid",

        ];
    }
}
