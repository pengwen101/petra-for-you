<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = ['panel discussion', 'talkshow', 'workshop', 'community service', 'open recruitment'];

        foreach($categories as $category){
            DB::table("event_categories")->insert([
                'name' => $category,
            ]);
        }
    }
}
