<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            'name' => 'Location Example',
            'code' => 'LEX',
            'zone_id' => '1',
            'startDate' => Carbon::create('1970', '01', '01'),
            'finishDate' => Carbon::create('2050', '12', '31')
        ]);
    }
}
