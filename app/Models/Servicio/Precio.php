<?php

namespace App\Models\Servicio;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Precio extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "VEPRCART";
    protected $guarded = ['Mb_Epr_cod', 'Ve_lista_precio', 'Art_cod', 've_lis_desde'];
    protected $primaryKey = ['Mb_Epr_cod', 'Ve_lista_precio', 'Art_cod', 've_lis_desde'];
    public $timestamps = false;
    public static $snakeAttributes = false;
}
