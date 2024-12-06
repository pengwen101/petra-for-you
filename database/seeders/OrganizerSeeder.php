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
            ['name' => 'Civil Engineering', 'type' => 'universitas'],
            ['name' => 'Architecture', 'type' => 'universitas'],
            ['name' => 'Architecture of Sustainable Housing and Real Estate', 'type' => 'universitas'],
            ['name' => 'Electrical Engineering, Internet of Things', 'type' => 'universitas'],
            ['name' => 'Sustainable Mechanical Engineering and Design', 'type' => 'universitas'],
            ['name' => 'Automotive Industrial Engineering', 'type' => 'universitas'],
            ['name' => 'Global Logistics and Supply Chain', 'type' => 'universitas'],
            ['name' => 'International Business Engineering', 'type' => 'universitas'],
            ['name' => 'Informatics', 'type' => 'universitas'],
            ['name' => 'Business Information System', 'type' => 'universitas'],
            ['name' => 'Data Science and Analytics', 'type' => 'universitas'],
            ['name' => 'Creative Tourism', 'type' => 'universitas'],
            ['name' => 'Hotel Management', 'type' => 'universitas'],
            ['name' => 'Finance and Investment', 'type' => 'universitas'],
            ['name' => 'Marketing Management', 'type' => 'universitas'],
            ['name' => 'Business Management', 'type' => 'universitas'],
            ['name' => 'Business Accounting', 'type' => 'universitas'],
            ['name' => 'Tax Accounting', 'type' => 'universitas'],
            ['name' => 'International Business Management', 'type' => 'universitas'],
            ['name' => 'International Business Accounting', 'type' => 'universitas'],
            ['name' => 'Elementary Teacher Education', 'type' => 'universitas'],
            ['name' => 'Early Childhood Teacher Education', 'type' => 'universitas'],
            ['name' => 'English for Creative Industry', 'type' => 'universitas'],
            ['name' => 'English for Business', 'type' => 'universitas'],
            ['name' => 'Chinese', 'type' => 'universitas'],
            ['name' => 'Interior Product Design', 'type' => 'universitas'],
            ['name' => 'International Program in Digital Media', 'type' => 'universitas'],
            ['name' => 'Textile and Fashion Design', 'type' => 'universitas'],
            ['name' => 'Interior Design and Styling', 'type' => 'universitas'],
            ['name' => 'Visual Communication Design', 'type' => 'universitas'],
            ['name' => 'Strategic Communication', 'type' => 'universitas'],
            ['name' => 'Broadcast and Journalism', 'type' => 'universitas'],
            ['name' => 'Badan Eksekutif Mahasiswa', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Pers Mahasiswa', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'BPMF 1', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'BPMF 2', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'BPMF 3', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Pelayanan Mahasiswa','type' => 'lembaga kemahasiswaan'],
            ['name' => 'Tim Petra Sinergi', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Majelis Perwakilan Mahasiswa', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Sastra Inggris', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Bahasa Mandarin', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Desain Interior', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Desain Komunikasi Visual', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Ilmu Komunikasi', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Informatika', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Teknik Mesin', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Teknik Industri', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Arsitektur', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Teknik Sipil', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Akuntansi', 'type' => 'lembaga kemahasiswaan'],
            ['name' => 'Himpunan Mahasiswa Pendidikan Guru Sekolah Dasar', 'type' => 'lembaga kemahasiswaan'],

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
                'email' => strtolower(str_replace(' ', '_', $organizer['name'])) . '@petra.ac.id',
                'password' => bcrypt('1234')
            ]);
        }
    }
}
