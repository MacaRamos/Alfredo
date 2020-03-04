<?php

namespace App\Models\Agenda;

use App\Models\Cliente\Cliente;
use App\Models\Especialista\Especialista;
use App\Models\Estado\Estado;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Agenda extends Model
{
    //GCAGENDA
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "GCAGENDA";
    protected $guarded = ['Age_EmpCod', 'Age_AgeCod', 'Age_SedCod', 'Age_EspCod'];
    protected $primaryKey = ['Age_EmpCod', 'Age_AgeCod', 'Age_SedCod', 'Age_EspCod'];
    public $timestamps = false;
    public static $snakeAttributes = false;

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'Cli_CodCli', 'Age_CliCod');
    }

    public function especialista()
    {
        return $this->hasOne(Especialista::class, ['Mb_Epr_cod', 'Ve_cod_ven'], ['Age_EmpCod', 'Age_EspCod']);
    }

    public function lineasDetalle()
    {
        return $this->hasMany(AgeDet::class, ['Age_EmpCod', 'Age_AgeCod', 'Age_SedCod'], ['Age_EmpCod', 'Age_AgeCod', 'Age_SedCod']);
    }

    public function estado(){
        return $this->hasOne(Estado::class, 'Estado', 'Age_Estado');
    }
}
