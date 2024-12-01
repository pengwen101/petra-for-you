<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            'nrp' => 'c14220160',
            'name' => 'amel',
            'email' => 'amelia@gmail.com',
            'password'=> bcrypt('1234'),
        ]);
    }
}
