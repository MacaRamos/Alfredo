<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = 'Permiso';
    protected $primaryKey = 'Per_codigo';
}
