<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'name' => 'Project Example',
            'code' => 'PROEXA',
            'city_id' => '1',
            'subsidiary_id' => '1',
            'startDate' => Carbon::create('1970', '01', '01'),
            'finishDate' => Carbon::create('2050', '12', '31'),
        ]);

        DB::table('projects')->insert([
            'name' => 'Consorcio Linea 1 Metro de Quito',
            'code' => 'CL1',
            'city_id' => '1',
            'subsidiary_id' => '1',
            'startDate' => Carbon::create('1970', '01', '01'),
            'finishDate' => Carbon::create('2050', '12', '31'),
        ]);
    }
}
