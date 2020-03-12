<?php

namespace App\Http\Requests;

use App\Rules\ValidarRUT;
use Illuminate\Foundation\Http\FormRequest;

class ValidacionEspecialista extends FormRequest
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
            'rut' => ['required', new ValidarRUT],
            'Ve_rut_ven' => 'required|max:10',
            'Ve_ven_dv' => 'required|max:1',
            'Ve_nombre_ven' => 'required|max:40',
            'Ve_ven_depto' => 'required|max:2',
            'Ve_tipo_ven' => 'required|max:1'
        ];
    }
    public function attributes()
    {
        return [
            'Ve_rut_ven' => 'RUT',
            'Ve_ven_dv' => 'DV',
            'Ve_nombre_ven' => 'Nombre',
            'Ve_ven_depto' => 'Local',
            'Ve_tipo_ven' => 'Tipo'
        ];
    }
}
