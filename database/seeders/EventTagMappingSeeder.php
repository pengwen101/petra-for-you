<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Tag;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventTagMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event_id_count = Event::get()->count();
        $tag_id_count = Tag::get()->count();

        for($i = 1; $i <=$event_id_count; $i++){
            $tag_count_per_event = rand(1, 3);
            $faker = Factory::create();
            for($j = 1; $j <= $tag_count_per_event; $j++){
                DB::table("event_tag_mappings")->insert([
                    'event_id' => $i,
                    'tag_id' => rand(1, $tag_id_count),
                    'notes' => $faker->words(3, true),
                ]);
            }
        }
    }
}
