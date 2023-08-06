<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('turns')->insert([
            'name' => 'Diurnal',
            'start' => '07:00',
            'finish' => '16:00',
            'project_id' => '1',
        ]);
    }
}
