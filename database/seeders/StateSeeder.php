<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            'name' => 'Pichincha',
            'country_id' => '1',
        ]);

        DB::table('states')->insert([
            'name' => 'Cataluña',
            'country_id' => '2',
        ]);
    }
}
