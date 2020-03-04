<?php

namespace App\Http\Requests;

use App\Rules\ValidarHoraFinal;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionAgenda extends FormRequest
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
            'Age_Fin' => [new ValidarHoraFinal]
        ];
    }

    public function attributes()
    {
        return [
            'Age_Fin' => 'Hora Final'
        ];
    }
}
