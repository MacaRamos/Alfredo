<?php

use App\Models\Admin\Permiso;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Permiso::class, 50)->create(); // o factory(Permiso::class)->times()->create();
    }
}
