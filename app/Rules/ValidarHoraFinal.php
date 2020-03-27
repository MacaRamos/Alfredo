<?php

namespace App\Rules;

use App\Models\Agenda\Agenda;
use Illuminate\Contracts\Validation\Rule;

class ValidarHoraFinal implements Rule
{
    private $Age_inicio;
    private $especialista;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($Age_inicio, $especialista)
    {
        $this->Age_inicio = $Age_inicio;
        $this->especialista = $especialista;
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
        $agenda = Agenda::where('Age_EspCod', '=', $this->especialista)
                        ->where('Age_Fecha', '=', date('d-m-Y', strtotime($value)))
                        ->where('Age_Inicio', '>', date('d-m-Y H:i:s', strtotime($this->Age_inicio)))//Inicio
                        ->where('Age_Fin', '<', date('d-m-Y H:i:s', strtotime($value)))//FIN
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
        return 'La hora que intenta agendar se topa con la siguiente.';
    }
}
