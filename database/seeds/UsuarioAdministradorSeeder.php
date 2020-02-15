<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioAdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Usuario')->insert([
            'Usu_usuario' => 'admin',
            'password' => bcrypt('admin123'),
            'Usu_nombre' => 'Administrador',
            'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
        ]);

        DB::table('Usuario')->insert([
            'Usu_usuario' => 'ditec',
            'password' => bcrypt('admin123'),
            'Usu_nombre' => 'Director Técnico',
            'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
        ]);

        DB::table('UsuarioRol')->insert([
            'Rol_codigo' => 1,
            'URol_estado' => 1,
            'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
        ]);

        DB::table('UsuarioRol')->insert([
            'Rol_codigo' => 2,
            'URol_estado' => 1,
            'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
        ]);
        
    }
}
