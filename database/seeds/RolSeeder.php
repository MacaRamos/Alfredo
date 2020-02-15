<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rols = [
            'administrador',
            'gerencia',
            'supervisor',
            'normal',
            'quimico',
            'contabilidad'
        ];
        foreach ($rols as $key => $value){
            DB::table('Rol')->insert([
                'Rol_nombre' => $value,
                'created_at' =>  Carbon::now()->format('d-m-y h:i:s')
            ]);
        }
    }
}
