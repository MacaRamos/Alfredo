<?php

namespace App\Models\Servicio;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class DuracionEspecialista extends Model
{
    //GCSERVICIO
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "GCSERVICIO";
    protected $guarded = ['Ser_EmpCod', 'Ser_SerCod', 'Ser_EspCod'];
    protected $primaryKey = ['Ser_EmpCod', 'Ser_SerCod', 'Ser_EspCod'];
    public $timestamps = false;
}
