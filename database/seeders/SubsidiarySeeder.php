<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubsidiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subsidiaries')->insert([
            'name' => 'Subsidiary Example',
            'code' => 'SE',
            'company_id' => '1',
            'division_id' => '1',
        ]);
    }
}
