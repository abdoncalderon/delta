<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StakeholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stakeholders')->insert([
            'name' => 'Contractor Example',
            'project_id' => '1',
            'city_id' => '1',
            'code' => 'CONEX',
            'stakeholder_type_id' => '1',
            'email' => 'abdonc@gmail.com',
        ]);

        DB::table('stakeholders')->insert([
            'name' => 'Client Example',
            'project_id' => '1',
            'city_id' => '1',
            'code' => 'CLIEX',
            'stakeholder_type_id' => '2',
            'email' => 'abdonc@gmail.com',
        ]);

        DB::table('stakeholders')->insert([
            'name' => 'Inspector Example',
            'project_id' => '1',
            'city_id' => '1',
            'code' => 'INSEX',
            'stakeholder_type_id' => '3',
            'email' => 'abdonc@gmail.com',
        ]);

        DB::table('stakeholders')->insert([
            'name' => 'Supplier Example',
            'project_id' => '1',
            'city_id' => '1',
            'code' => 'SUPEX',
            'stakeholder_type_id' => '4',
            'email' => 'abdonc@gmail.com',
        ]);
    }
}
