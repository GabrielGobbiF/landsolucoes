<?php

namespace App\Http\Requests\Frotas;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StoreUpdateDriver extends FormRequest
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
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'cpf' => ['required', 'string', 'min:1', 'max:255'],
            'cnh_number' => ['required', 'string', 'min:1', 'max:255'],
            'cnh_category' => ['required', 'string', 'min:1', 'max:255'],
            'cnh_validity' => ['required', 'date', 'after_or_equal:1970-01-01 00:00:01', 'before_or_equal:2038-01-19 03:14:07'],
            're' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }

      /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'cnh_validity' => $this->validateDate($this->cnh_validity),
        ]);
    }

    private function validateDate($date)
    {
        if (!$date) {
            return null;
        }

        #throw_if(
        #    !validateDate($date, 'd/m/Y H:i'),
        #    ValidationException::withMessages(['visitor_at' => 'Por favor digite uma data válida'])
        #);

        return date_format(Carbon::parse(str_replace('/', '-', $date)), 'Y-m-d H:i:s');
    }
}
