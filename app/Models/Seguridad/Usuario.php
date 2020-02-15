<?php

namespace App\Models\Seguridad;

use App\Models\Admin\Rol;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $remember_token = false;
    protected $table = 'Usuario';
    protected $fillable = ['Usu_usuario', 'Usu_nombre', 'password'];
    protected $guarded = ['Usu_codigo'];
    protected $primaryKey = 'Usu_codigo';

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'UsuarioRol', 'Usu_codigo', 'Rol_codigo');
    }

    public function setSession($roles)
    {
        if (count($roles) == 1) {
            Session::put(
                [
                    'Rol_codigo' => $roles[0]['Rol_codigo'],
                    'Rol_nombre' => $roles[0]['Rol_nombre'],
                    'Usu_usuario' => $this->Usu_usuario,
                    'Usu_codigo' => $this->Usu_codigo,
                    'Usu_nombre' => $this->Usu_nombre,
                    'Usu_apellido' => $this->Usu_apellido,
                ]
            );
        }
    }
}
