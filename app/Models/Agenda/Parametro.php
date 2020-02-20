<?php

namespace App\Models\Agenda;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class Parametro extends Model
{
    use HasCompositePrimaryKey;
    use Compoships;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = "GCPARAM";
    protected $guarded = ['Nombre', 'Valor'];
    protected $primaryKey = ['Nombre'];
    public $timestamps = false;

}
