<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('people')->insert([
            'uid' => '0000000000',
            'firstName' => 'Super',
            'LastName' => 'User',
            'fullName' => 'Super User',
            'gender_id' => '1',
            'birthDate' => Carbon::create('1970', '01', '01'),
            'isActive' => 1,
        ]);

        DB::table('people')->insert([
            'uid' => '1308864642',
            'firstName' => 'Abdon Antonio',
            'LastName' => 'Calderon Macias',
            'fullName' => 'Calderon Macias Abdon Antonio',
            'gender_id' => '1',
            'birthDate' => Carbon::create('1977', '08', '30'),
            'isActive' => 1,
        ]);

        DB::table('people')->insert([
            'uid' => '1308050705',
            'firstName' => 'Fanny Rocio',
            'LastName' => 'Garcia Bazurto',
            'fullName' => 'Garcia Bazurto Fanny Rocio',
            'gender_id' => '2',
            'birthDate' => Carbon::create('1978', '04', '01'),
            'isActive' => 1,
        ]);

        DB::table('people')->insert([
            'uid' => '1701010101',
            'firstName' => 'Evelyn',
            'LastName' => 'Villarreal',
            'fullName' => 'Villarreal Evelyn',
            'gender_id' => '2',
            'birthDate' => Carbon::create('1980', '01', '01'),
            'isActive' => 1,
        ]);
    }
}
