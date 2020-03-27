<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidarDuracionHora implements Rule
{
    private $Age_Fin;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($Age_Fin)
    {
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
        
        if(date('d-m-Y H:i:s', strtotime($value)) < date('d-m-Y H:i:s', strtotime($this->Age_Fin))){
            return true;
        } else {
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
        return 'La duración de la hora que intenta agendar no es válida, verfíque la duración de los servicios.';
    }
}
