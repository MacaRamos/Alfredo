<?php

namespace App\Models\Servicio;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Servicio extends Model
{
    //ARTMAESTRO
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "ARTMAESTRO";
    protected $guarded = ['Mb_Epr_cod', 'Art_cod'];
    protected $primaryKey = ['Mb_Epr_cod', 'Art_cod'];
    public $timestamps = false;
    public static $snakeAttributes = false;

    public function tiempoGeneral(){
        return $this->hasOne(Duracion::class, ['Dur_EmpCod', 'Dur_SerCod'], ['Mb_Epr_cod', 'Art_cod']);
    }
    public function tiempoEspecialista(){
        return $this->hasOne(DuracionEspecialista::class, ['Ser_EmpCod', 'Ser_SerCod'], ['Mb_Epr_cod', 'Art_cod']);
    }

    public function precio(){
        return $this->hasOne(Precio::class, ['Mb_Epr_cod', 'Art_cod'], ['Mb_Epr_cod', 'Art_cod']);
    }

    public function clase(){
        return $this->hasOne(Clase::class, 'Gc_cla_cod', 'Gc_cla_cod');
    }

    public function familia(){
        return $this->hasOne(Familia::class, 'Gc_fam_cod', 'Gc_fam_cod');
    }
}
