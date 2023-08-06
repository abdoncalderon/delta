<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            'name' => 'Ecuador',
            'region_id' => '1',
            'code' => 'EC',
            'ccc' => '593',
        ]);

        DB::table('countries')->insert([
            'name' => 'España',
            'region_id' => '2',
            'code' => 'ES',
            'ccc' => '34',
        ]);
    }
}
