<?php

namespace App\Models\Seguridad;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class TSEG02 extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "TSEG02";
    protected $guarded = ['Mb_Epr_cod', 'Seg_usuario'];
    protected $primaryKey = ['Mb_Epr_cod', 'Seg_usuario'];
    public $timestamps = false;
}
