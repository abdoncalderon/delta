<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'name' => __('content.material'),
        ]);

        DB::table('groups')->insert([
            'name' => __('content.product'),
        ]);

        DB::table('groups')->insert([
            'name' => __('content.asset'),
        ]);

        DB::table('groups')->insert([
            'name' => __('messages.assetControlled'),
        ]);

        DB::table('groups')->insert([
            'name' => __('content.service'),
        ]);
    }
}
