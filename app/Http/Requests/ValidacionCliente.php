<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidacionCliente extends FormRequest
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
            'Cli_CodCli' => 'unique:Clientes,Cli_CodCli,' . $this->route('Cli_CodCli') . ',Cli_CodCli',
            'Cli_NomCli' => 'required|max:60|unique:Clientes,Cli_NomCli',
            'Cli_NumCel' => 'required|min:9|max:9',
            'Cli_NumFij' => 'max:9'
        ];
    }

    public function attributes()
    {
        return [
            'Cli_NomCli' => 'Nombre',
            'Cli_NumCel' => 'Celular',
            'Cli_NumFij' => 'Fijo',
            'Cli_CodCli' => 'Código'
        ];
    }
}
