<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = 'Rol';
    protected $fillable = ['Rol_nombre'];// campos que se guardan en la base de datos
    protected $guarded = ['Rol_codigo'];
    protected $primaryKey = 'Rol_codigo';
}
