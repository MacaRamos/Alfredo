<?php

namespace App\Models\Sede;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Sede extends Model
{
    //EMPRESEDE
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "EMPRESEDE";
    protected $guarded = ['Mb_Epr_cod', 'Mb_Sedecod'];
    protected $primaryKey = ['Mb_Epr_cod', 'Mb_Sedecod'];
    public $timestamps = false;
}
