<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('location_project_users')->insert([
            'location_id' => '1',
            'project_user_id' => '1',
            'profile' => '1',
            'receive_notification' => '1',
        ]);
    }
}
