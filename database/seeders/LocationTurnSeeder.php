<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LocationTurnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('location_turns')->insert([
            'location_id' => '1',
            'turn_id' => '1',
            'dateFrom' => Carbon::create('1970', '01', '01'),
            'dateTo' => Carbon::create('2050', '12', '31')
        ]);
    }
}
