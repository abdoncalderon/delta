<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FunctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('funct1ons')->insert([
            'name' => 'Asistente',
            'project_id' => '1',
        ]);

        DB::table('funct1ons')->insert([
            'name' => 'Auxiliar',
            'project_id' => '1',
        ]);

        DB::table('funct1ons')->insert([
            'name' => 'Coordinador',
            'project_id' => '1',
        ]);

        DB::table('funct1ons')->insert([
            'name' => 'Director',
            'project_id' => '1',
        ]);

        DB::table('funct1ons')->insert([
            'name' => 'Especialista',
            'project_id' => '1',
        ]);

        DB::table('funct1ons')->insert([
            'name' => 'Gerente',
            'project_id' => '1',
        ]);

        DB::table('funct1ons')->insert([
            'name' => 'Jefe',
            'project_id' => '1',
        ]);

        DB::table('funct1ons')->insert([
            'name' => 'Obrero',
            'project_id' => '1',
        ]);

        DB::table('funct1ons')->insert([
            'name' => 'Responsable',
            'project_id' => '1',
        ]);

        DB::table('funct1ons')->insert([
            'name' => 'Técnico',
            'project_id' => '1',
        ]);
    }
}
