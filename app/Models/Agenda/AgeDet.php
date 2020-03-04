<?php

namespace App\Models\Agenda;

use App\Models\Servicio\Servicio;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class AgeDet extends Model
{
    //GCAGEDET
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "GCAGEDET";
    protected $guarded = ['Age_EmpCod', 'Age_AgeCod', 'Age_SedCod', 'Age_EspCod', 'Age_SerCod'];
    protected $primaryKey = ['Age_EmpCod', 'Age_AgeCod', 'Age_SedCod', 'Age_EspCod', 'Age_SerCod'];
    public $timestamps = false;

    public function articulo()
    {
        return $this->hasOne(Servicio::class, ['Mb_Epr_cod', 'Art_cod'], ['Age_EmpCod','Age_SerCod']);
    }

}
