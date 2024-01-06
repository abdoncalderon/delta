<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class StakeholderPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stakeholder_people')->insert([
            'stakeholder_id' => '1',
            'person_id' => '1',
            'admissionDate' => Carbon::create('1970', '01', '01'),
            'hiredSince' => Carbon::create('2016', '01', '01'),
            'cardNo' => 42345566,
            'position_id' => '1',
            'department_id' => '1',
        ]);

        DB::table('stakeholder_people')->insert([
            'stakeholder_id' => '1',
            'person_id' => '2',
            'admissionDate' => Carbon::create('2016', '01', '01'),
            'hiredSince' => Carbon::create('2016', '01', '01'),
            'cardNo' => 4758871,
            'position_id' => '1',
            'department_id' => '1',
            'businessEmail' => 'abdonc@gmail.com',
        ]);

        DB::table('stakeholder_people')->insert([
            'stakeholder_id' => '1',
            'person_id' => '3',
            'admissionDate' => Carbon::create('2016', '01', '01'),
            'hiredSince' => Carbon::create('2016', '01', '01'),
            'cardNo' => 42345568,
            'position_id' => '1',
            'department_id' => '1',
            'businessEmail' => 'fannygarciab@hotmail.es',
            'isApprover' => '1',
        ]);

        DB::table('stakeholder_people')->insert([
            'stakeholder_id' => '4',
            'person_id' => '4',
            'admissionDate' => Carbon::create('2016', '01', '01'),
            'hiredSince' => Carbon::create('2016', '01', '01'),
            'cardNo' => 42345569,
            'position_id' => '1',
            'department_id' => '1',
            'businessEmail' => 'evillarreal@consorciolinea1.com',
            'isApprover' => '0',
        ]);
    }
}


