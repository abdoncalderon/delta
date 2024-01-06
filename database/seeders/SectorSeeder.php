<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sectors')->insert([
            'name' => 'Administracion',
            'project_id' => '1',
        ]);

        DB::table('sectors')->insert([
            'name' => 'Calidad',
            'project_id' => '1',
        ]);

        DB::table('sectors')->insert([
            'name' => 'Comercial',
            'project_id' => '1',
        ]);

        DB::table('sectors')->insert([
            'name' => 'Dirección',
            'project_id' => '1',
        ]);

        DB::table('sectors')->insert([
            'name' => 'Finanzas y Contabilidad',
            'project_id' => '1',
        ]);

        DB::table('sectors')->insert([
            'name' => 'Ingenieria',
            'project_id' => '1',
        ]);

        DB::table('sectors')->insert([
            'name' => 'Legal',
            'project_id' => '1',
        ]);

        DB::table('sectors')->insert([
            'name' => 'Producción',
            'project_id' => '1',
        ]);

        DB::table('sectors')->insert([
            'name' => 'Recursos Humanos',
            'project_id' => '1',
        ]);

        DB::table('sectors')->insert([
            'name' => 'Seguridad, Salud y Medio Ambiente',
            'project_id' => '1',
        ]);
    }
}
