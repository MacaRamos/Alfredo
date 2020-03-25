<?php

namespace App\Models\Servicio;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    //ARTFAMILIA
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "ARTFAMILIA";
    protected $guarded = ['Gc_fam_cod', 'Gc_fam_desc', 'Gc_fam_uti'];
    protected $primaryKey = 'Gc_fam_cod';
    public $timestamps = false;
    public static $snakeAttributes = false;
}
