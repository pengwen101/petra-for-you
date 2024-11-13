<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventEventCategoryMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event_id_count = Event::get()->count();
        $event_category_id_count = EventCategory::get()->count();

        for($i = 1; $i <=$event_id_count; $i++){
            $event_category_count_per_event = rand(2, 6);
            $faker = Factory::create();
            for($j = 1; $j <= $event_category_count_per_event; $j++){
                DB::table("event_event_category_mappings")->insert([
                    'event_id' => rand(1, $event_id_count),
                    'event_category_id' => rand(1, $event_category_id_count),
                ]);
            }
        }
    }
}
