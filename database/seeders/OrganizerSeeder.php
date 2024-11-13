<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    
    public function run(): void
    {
    
        $organizers = [
            [
                'name' => 'Jurusan Informatika', 
                'type' => 'universitas'
            ],

            [
                'name' => 'Badan Eksekutif Mahasiswa', 
                'type' => 'lembaga kemahasiswaan'
            ],
            [
                'name' => 'Himpunan Mahasiswa Informatika', 
                'type' => 'lembaga kemahasiswaan'
            ],
            [
                'name' => 'Pers Mahasiswa', 
                'type' => 'lembaga kemahasiswaan'
            ],
            [
                'name' => 'BPMF 1', 
                'type' => 'lembaga kemahasiswaan'
            ],

            [
                'name' => 'BPMF 2', 
                'type' => 'lembaga kemahasiswaan'
            ],

            [
                'name' => 'BPMF 3', 
                'type' => 'lembaga kemahasiswaan'
            ],

            [
                'name' => 'Pelayanan Mahasiswa', 
                'type' => 'lembaga kemahasiswaan'
            ],

            [
                'name' => 'Tim Petra Sinergi', 
                'type' => 'lembaga kemahasiswaan'
            ],

            [
                'name' => 'Majelis Perwakilan Mahasiswa', 
                'type' => 'lembaga kemahasiswaan'
            ],

        ];
        
        foreach($organizers as $organizer){
            $faker = Factory::create();
            DB::table("organizers")->insert([
                'name' => $organizer['name'],
                'type' => $organizer['type'],
                'description' => $faker->paragraph(),
                'instagram_link' => $faker->url(),
                'website_link' => $faker->url(),
                'phone_number' => $faker->randomNumber(8, true),
                'line_id' => $faker->word(),
            ]);
        }
    }
}
