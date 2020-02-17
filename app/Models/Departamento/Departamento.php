<?php

namespace App\Models\Departamento;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Departamento extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "DEPARTAMENTO";
    protected $guarded = ['Mb_Cod_Dep', 'Mb_Nom_Dep'];
    protected $primaryKey = 'Mb_Cod_Dep';
    public $timestamps = false;
}
