<?php

namespace App\Models\Especialista;

use App\Models\Agenda\Agenda;
use App\Models\Departamento\Departamento;
use App\Models\Servicio\DuracionEspecialista;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Especialista extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "VEVENDEF";
    protected $guarded = ['Mb_Epr_cod', 'Ve_cod_ven'];
    protected $primaryKey = ['Mb_Epr_cod', 'Ve_cod_ven'];
    public $timestamps = false;

    public function departamento()
    {
        return $this->hasOne(Departamento::class, 'Mb_Cod_Dep', 'Ve_ven_depto');
    }

    public function duracion()
    {
        return $this->hasOne(DuracionEspecialista::class, 'Ser_EspCod', 'Ve_cod_ven');
    }

    public function agendas(){
        return $this->hasMany(Agenda::class, 'Age_EspCod', 'Ve_cod_ven');
    }
}
