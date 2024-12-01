<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Tag;
use App\Models\Organizer;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $organizer_id_count = Organizer::get()->count();

        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            DB::table("events")->insert([
                'title' => $faker->sentence(3),
                'venue' => $faker->sentence(1),
                'start_date' => $faker->date(),
                'end_date' => $faker->date(),
                'start_time' => $faker->time(),
                'end_time' => $faker->time(),
                'description' => $faker->paragraph(),
                'price' => $faker->numberBetween(20000, 200000),
                'organizer_id' => $faker->numberBetween(1, $organizer_id_count),
            ]);
        }
    }
}
