<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('regions')->insert([
            'name' => 'América del Sur',
        ]);

        DB::table('regions')->insert([
            'name' => 'Europa occidental',
        ]);

        DB::table('regions')->insert([
            'name' => 'Europa meridional',
        ]);

        DB::table('regions')->insert([
            'name' => 'Europa oriental',
        ]);

        DB::table('regions')->insert([
            'name' => 'Europa septentrional',
        ]);

        DB::table('regions')->insert([
            'name' => 'África central',
        ]);

        DB::table('regions')->insert([
            'name' => 'África meridional',
        ]);

        DB::table('regions')->insert([
            'name' => 'África occidental',
        ]);

        DB::table('regions')->insert([
            'name' => 'África oriental',
        ]);

        DB::table('regions')->insert([
            'name' => 'África septentrional',
        ]);

        DB::table('regions')->insert([
            'name' => 'América central',
        ]);

        DB::table('regions')->insert([
            'name' => 'América del Norte',
        ]);

        DB::table('regions')->insert([
            'name' => 'Caribe',
        ]);

        DB::table('regions')->insert([
            'name' => 'Asia central',
        ]);

        DB::table('regions')->insert([
            'name' => 'Asia meridional',
        ]);

        DB::table('regions')->insert([
            'name' => 'Asia occidental',
        ]);

        DB::table('regions')->insert([
            'name' => 'Asia oriental',
        ]);

        DB::table('regions')->insert([
            'name' => 'Asia sudoriental',
        ]);

        DB::table('regions')->insert([
            'name' => 'Australia y Nueva Zelanda',
        ]);

        DB::table('regions')->insert([
            'name' => 'Melanesia',
        ]);

        DB::table('regions')->insert([
            'name' => 'Micronesia',
        ]);

        DB::table('regions')->insert([
            'name' => 'Polinesia',
        ]);
    }
}
