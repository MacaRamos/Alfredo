<?php

namespace App\Models\Servicio;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Duracion extends Model
{
    //SERVDURA
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "SERVDURA";
    protected $guarded = ['Dur_EmpCod', 'Dur_SerCod'];
    protected $primaryKey = ['Dur_EmpCod', 'Dur_SerCod'];
    public $timestamps = false;
}
