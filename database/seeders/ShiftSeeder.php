<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shifts')->insert([
            'name' => 'Diurnal',
            'start' => '07:00',
            'finish' => '16:00',
            'breaktime' => '01:00',
            'earlyCheckin' => '00:15',
            'lateCheckout' => '00:15',
            'project_id' => '1',
        ]);
    }
}
