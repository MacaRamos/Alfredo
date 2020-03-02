<?php

namespace App\Models\Estado;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Estado extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    //Estado
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "Estado";
    protected $guarded = ['Estado', 'Nombre'];
    protected $primaryKey = 'Estado';
    public $timestamps = false;
}
