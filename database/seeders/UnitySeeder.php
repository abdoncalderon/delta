<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unities')->insert([
            'name' =>  'unidades',
            'code' =>  'u',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'metros lineales',
            'code' =>  'm',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'metros cuadrados',
            'code' =>  'm2',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'metros cubicos',
            'code' =>  'm3',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'kilogramos',
            'code' =>  'kg',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'libras',
            'code' =>  'lb',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'litros',
            'code' =>  'l',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'amperios',
            'code' =>  'A',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'candelas',
            'code' =>  'cd',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'dias',
            'code' =>  'd',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'gigabytes',
            'code' =>  'Gb',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'hectareas',
            'code' =>  'ha',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'hertzios',
            'code' =>  'Hz',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'horas',
            'code' =>  'h',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'kelvins',
            'code' =>  'k',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'lumens',
            'code' =>  'lm',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'megabytes',
            'code' =>  'Mb',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'metros por segundo',
            'code' =>  'mxs',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'minutos',
            'code' =>  'min',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'mols',
            'code' =>  'mol',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'newtons',
            'code' =>  'N',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'onzas',
            'code' =>  'oz',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'Pascales',
            'code' =>  'Pa',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'segundos',
            'code' =>  's',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'toneladas',
            'code' =>  't',
        ]);
        
         
        DB::table('unities')->insert([
            'name' =>  'vatios',
            'code' =>  'W',
        ]);
        
         
        
        
    }
}
