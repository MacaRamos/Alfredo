<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionServicio extends FormRequest
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
            'Art_cod' => 'required|max:15:unique:ARTMAESTRO,Art_cod,'.$this->route('Art_cod').'',
            'Art_nom_externo' => 'required|max:60',
            'Gc_fam_cod' => 'max:1',
            'Gc_cla_cod' => 'required|max:1',
        ];
    }

    public function attributes()
        {
            return [
                'Art_cod' => 'Código',
                'Art_nom_externo' => 'Nombre',
                'Gc_fam_cod' => 'Familia',
                'Gc_cla_cod' => 'Clase'
            ];
        }
}
