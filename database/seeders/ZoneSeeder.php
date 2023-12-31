<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zones')->insert([
            'name' => 'Tramo Norte',
            'project_id' => '1',
        ]);

        DB::table('zones')->insert([
            'name' => 'Tramo Centro',
            'project_id' => '1',
        ]);

        DB::table('zones')->insert([
            'name' => 'Tramo Sur',
            'project_id' => '1',
        ]);
    }
}
