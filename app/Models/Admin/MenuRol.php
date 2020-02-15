<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use LaravelTreats\Model\Traits\HasCompositePrimaryKey;

class MenuRol extends Model
{
    use HasCompositePrimaryKey;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = 'MenuRol';
    protected $fillable = ['Rol_codigo', 'Men_id'];// campos que se guardan en la base de datos
    protected $guarded = ['Rol_codigo', 'Men_id'];
    protected $primaryKey = ['Rol_codigo', 'Men_id'];
    public $timestamps = false;
}