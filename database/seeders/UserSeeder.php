<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user' => 'su',
            'email' => 'example@email.com',
            'password' => Hash::make('IdonSoft'),
            'person_id' => '1',
        ]);

        DB::table('users')->insert([
            'user' => 'acalderon4642',
            'email' => 'abdonc@gmail.com',
            'password' => Hash::make('1308864642'),
            'person_id' => '2',
        ]);

        DB::table('users')->insert([
            'user' => 'fgarcia0705',
            'email' => 'fannygarciab@hotmail.es',
            'password' => Hash::make('1308050705'),
            'person_id' => '3',
        ]);

        DB::table('users')->insert([
            'user' => 'evillarreal0101',
            'email' => 'evillarreal@consorciolinea1.com',
            'password' => Hash::make('1701010101'),
            'person_id' => '4',
        ]);
    }
}
