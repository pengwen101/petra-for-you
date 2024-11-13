<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $tags = ['technology', 'data', 'business', 'accounting', 'english', 'entrepreneurship', 'leadership', 'marketing'];
        foreach($tags as $tag){
            DB::table("tags")->insert([
                'name' => $tag
            ]);
        }
       
    }
}
