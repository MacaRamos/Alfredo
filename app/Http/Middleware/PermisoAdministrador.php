<?php

namespace App\Http\Middleware;

use Closure;

class PermisoAdministrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->permiso())
        return $next($request);
        $notificacion = array(
            'mensaje' => 'No tiene permiso para entrar aquí',
            'tipo' => 'success',
            'titulo' => 'Receta'
        );
        return redirect('/')->with($notificacion);
    }

    private function permiso()
    {
        return session()->get('Rol_nombre')=='Administrador';
    }
}
