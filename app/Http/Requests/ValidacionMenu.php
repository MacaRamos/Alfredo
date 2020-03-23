<?php

namespace App\Http\Requests;

use App\Rules\ValidarCampoUrl;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionMenu extends FormRequest
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
            'Men_nombre' => 'required|max:50|unique:Menu,Men_nombre,'.$this->route('Men_id').',Men_id',
            'Men_url' => ['required', 'max:100', new ValidarCampoUrl],
            'Men_icono' => 'nullable|max:50'
        ];
    }
    public function attributes()
    {
        return[
            'Men_nombre' => 'Nombre',
            'Men_url' => 'URL',
            'Men_icono' => 'Icóno'
        ];
    }
}
