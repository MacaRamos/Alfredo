<?php

namespace App\Models\Especialista;

use App\Models\Departamento\Departamento;
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
}
