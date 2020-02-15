<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->TruncateTables([
            'Rol',
            'Permiso',
            'Usuario',
            'UsuarioRol'
        ]);
        $this->call(RolSeeder::class);
        $this->call(PermisoSeeder::class);
        $this->call(UsuarioAdministradorSeeder::class);
    }
    protected function TruncateTables(array $tables)
    {
        foreach ($tables as $table){
            DB::table($table)->delete();
            if ($table == 'Rol' || $table == 'Permiso' || $table == 'Usuario'){
                DB::statement('DBCC CHECKIDENT ('.$table.', RESEED, 0)');
            }
        }
    }
}
