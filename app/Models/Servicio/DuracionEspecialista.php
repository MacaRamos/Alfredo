<?php

namespace App\Models\Servicio;

use App\Models\Especialista\Especialista;
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
    public static $snakeAttributes = false;

    public function servicio(){
        return $this->hasOne(Servicio::class, 'Art_cod', 'Ser_SerCod');
    }

    public function especialista(){
        return $this->hasOne(Especialista::class, 'Ve_cod_ven', 'Ser_EspCod');
    }
}
