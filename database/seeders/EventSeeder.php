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

        $faker = Factory::create();
        $organizer_id_count = Organizer::get()->count();
        $maxRegisterDate = $faker->dateTimeBetween('2024-11-01', '2024-12-15')->format('Y-m-d');
        $startDate = $faker->dateTimeBetween($maxRegisterDate, '2024-12-20')->format('Y-m-d');
        $endDate = $faker->dateTimeBetween($startDate, '2024-12-31')->format('Y-m-d');

    
        for ($i = 0; $i < 20; $i++) {
            DB::table("events")->insert([
                'title' => $faker->sentence(3),
                'venue' => $faker->sentence(1),
                'max_register_date' => $maxRegisterDate,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'start_time' => $faker->time(),
                'end_time' => $faker->time(),
                'description' => $faker->paragraph(),
                'price' => $faker->numberBetween(20000, 200000),
                'organizer_id' => $faker->numberBetween(1, $organizer_id_count),
                // 'tag_id' => $faker->numberBetween(1, $tag_id_count),
            ]);
        }
    }
}
