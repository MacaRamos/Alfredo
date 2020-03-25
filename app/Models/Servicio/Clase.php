<?php

namespace App\Models\Servicio;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Clase extends Model
{
    //ARTCLASE
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "ARTCLASE";
    protected $guarded = ['Gc_fam_cod', 'Gc_cla_cod', 'Gc_cla_desc'];
    protected $primaryKey = ['Gc_fam_cod', 'Gc_cla_cod'];
    public $timestamps = false;
    public static $snakeAttributes = false;
}
