<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionRol extends FormRequest
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
            'Rol_nombre' => 'required|max:50|unique:Rol,Rol_nombre,'.$this->route('Rol_codigo').',Rol_codigo',
        ];
    }
    public function messages()
    {
        return [
            'Rol_nombre.required' => 'El campo nombre es requerido',
        ];
    }
}
