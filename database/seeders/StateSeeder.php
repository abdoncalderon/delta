<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('states')->insert([
            'name' => 'Pichincha',
            'country_id' => '1',
        ]);
        DB::table('states')->insert([
            'name' => 'Cataluña',
            'country_id' => '2',
        ]);
        DB::table('states')->insert([
            'name' => 'Azuay',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Bolivar',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Cañar',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Carchi',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Chimborazo',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Cotopaxi',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'El Oro',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Esmeraldas',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Galápagos',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Guayas',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Imbabura',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Loja',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Los Ríos',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Manabí',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Morona Santiago',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Napo',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Sucumbíos',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Pastaza',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Santa Elena',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Santo Domingo',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Francisco De Orellana',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Tungurahua',
            'country_id' => '1',	
        ]); 
        DB::table('states')->insert([
            'name' => 'Zamora Chinchipe',
            'country_id' => '1',	
        ]); 
        
        
    }
}
