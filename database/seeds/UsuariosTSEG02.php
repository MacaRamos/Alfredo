<?php

use App\Models\Seguridad\TSEG02;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosTSEG02 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('DBCC CHECKIDENT (Usuario, RESEED, 0)');
        DB::statement('DBCC CHECKIDENT (UsuarioRol, RESEED, 0)');
        $usuarios = TSEG02::get();

        foreach ($usuarios as $usuario){
            DB::table('Usuario')->insert([
                'Usu_usuario' => trim($usuario->Seg_usuari),
                'password' => bcrypt('INS'.trim($usuario->Seg_clave)),
                'Usu_nombre' => trim($usuario->Seg_Nombre),
                'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
            ]);

            if ($usuario->Seg_sup == 'G'){
                DB::table('UsuarioRol')->insert([
                    'Rol_codigo' => 2,
                    'URol_estado' => 1,
                    'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
                ]);
            }
            if ($usuario->Seg_sup == 'S'){
                DB::table('UsuarioRol')->insert([
                    'Rol_codigo' => 3,
                    'URol_estado' => 1,
                    'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
                ]);
            }
            if ($usuario->Seg_sup == 'N' && trim($usuario->Seg_usuari) != 'DIRECCION.TECNICA'){
                DB::table('UsuarioRol')->insert([
                    'Rol_codigo' => 4,
                    'URol_estado' => 1,
                    'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
                ]);
            }
            if ($usuario->Seg_sup == 'C'){
                DB::table('UsuarioRol')->insert([
                    'Rol_codigo' => 6,
                    'URol_estado' => 1,
                    'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
                ]);
            }
            if (trim($usuario->Seg_usuari) == 'DIRECCION.TECNICA'){
                DB::table('UsuarioRol')->insert([
                    'Rol_codigo' => 5,
                    'URol_estado' => 1,
                    'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
                ]);
            }
        }
        
    }
}
