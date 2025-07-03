<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pets')->insert([
            'name'        => 'Firulais',
            'kind'        => 'Dog',
            'weight'      => 16,
            'age'         => 24,
            'breed'       => 'Shiba Inu',
            'location'    => 'Kioto',
            'description' => 'Agile Japanese breed known for its fox-like appearance, spirited personality, and thick double coat',
            'status'      => 1,
            'created_at'  => now()
        ]);

        DB::table('pets')->insert([
            'name'        => 'Michi',
            'kind'        => 'Cat',
            'weight'      => 4,
            'age'         => 18,
            'breed'       => 'Siamés',
            'location'    => 'Osaka',
            'description' => 'Sleek, vocal breed with striking blue eyes, a short coat, and distinctive color points on ears, face, paws, and tail.',
            'status'      => 1,
            'created_at'  => now()
        ]);

        DB::table('pets')->insert([
            'name'        => 'Killer',
            'kind'        => 'Dog',
            'weight'      => 5,
            'age'         => 48,
            'breed'       => 'French Poodle',
            'location'    => 'Tokio',
            'description' => 'Intelligent, elegant breed known for its curly coat, playful nature, and versatility in various dog sports',
            'status'      => 1,
            'created_at'  => now()
        ]);
    }
}
