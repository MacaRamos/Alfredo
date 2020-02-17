<?php

namespace App\Models\Agenda;

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
}
