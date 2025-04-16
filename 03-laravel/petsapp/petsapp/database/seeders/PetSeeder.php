<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pets')->insert([
            'name' => 'firulais',
            'kind' => 'Dog',
            'weight' => '16',
            'age' => '24',
            'breed' => 'Pitbull',
            'location'=> 'mayu',
            'description' => 'ninguna descripcion',
            'created_at' => now()
        ]);

        DB::table('pets')->insert([
            'name' => 'Max',
            'kind' => 'Dog',
            'weight' => '16',
            'age' => '12',
            'breed' => 'Angora',
            'location'=> 'Colombia',
            'description' => 'tiene un ojo tuerto',
            'created_at' => now()
        ]);

        DB::table('pets')->insert([
            'name' => 'Pochito',
            'kind' => 'Cat',
            'weight' => '6',
            'age' => '2',
            'breed' => 'Siames',
            'location'=> 'Mexico',
            'description' => 'es muy jugueton',
            'created_at' => now()
        ]);
    }
}
