<?php

namespace App\Rules;

use App\Models\Agenda\Agenda;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidarHoraCliente implements Rule
{
    private $Age_Inicio;
    private $Age_Fin;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($Age_Inicio, $Age_Fin)
    {
        $this->Age_Inicio = $Age_Inicio;
        $this->Age_Fin = $Age_Fin;
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $agenda = Agenda::where('Age_CliCod', '=', $value)
                        ->where('Age_Fecha', '=', date('d-m-Y', strtotime($this->Age_Inicio)))
                        ->where('Age_Inicio', '>=', date('d-m-Y H:i:s', strtotime($this->Age_Inicio)))//Inicio
                        ->where('Age_Fin', '<=', date('d-m-Y H:i:s', strtotime($this->Age_Fin)))//FIN
                        ->get();

        if($agenda->isEmpty()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El cliente ya se encuentra agendado con otro especialista a la misma hora.';
    }
}
