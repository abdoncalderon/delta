<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'SuperUser',
        ]);

        DB::table('roles')->insert([
            'name' => 'Project Admin',
        ]);

        DB::table('roles')->insert([
            'name' => 'Project User',
        ]);
    }
}
