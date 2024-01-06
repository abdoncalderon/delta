<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class WorkbookUserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('workbook_user_profiles')->insert([
            'name' => 'content.collaborator',
        ]);

        DB::table('workbook_user_profiles')->insert([
            'name' => 'content.reviewer',
        ]);

        DB::table('workbook_user_profiles')->insert([
            'name' => 'content.approver',
        ]);
    }
}
