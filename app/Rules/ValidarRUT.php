<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Facades\ChileRut as RUT;

class ValidarRUT implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if (RUT::check($value)) {
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
        return 'El RUT no es válido';
    }
}
