<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'name' => 'Quito',
            'state_id' => '1',
        ]);

        DB::table('cities')->insert([
            'name' => 'Barcelona',
            'state_id' => '2',
        ]);
    }
}
