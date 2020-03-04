<?php

namespace App\Rules;

use App\Models\Agenda\Agenda;
use Illuminate\Contracts\Validation\Rule;

class ValidarHoraFinal implements Rule
{
    private $Age_inicio;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($Age_inicio)
    {
        $this->Age_inicio = $Age_inicio;
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
        $agenda = Agenda::where('Age_Fecha', '=', date('d-m-Y', strtotime($value)))
                        ->where('Age_Inicio', '>', date('d-m-Y H:i:s', strtotime($this->Age_inicio)))//Inicio
                        ->where('Age_Inicio', '<', date('d-m-Y H:i:s', strtotime($value)))//FIN
                        ->get();


                        //inicio < age_inicio < value < fin
                        //inicio < age_inicio
                        //value < fin
        //dd($agenda);
        
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
