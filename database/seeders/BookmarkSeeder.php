<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_id_count = User::get()->count();
        $event_id_count = Event::get()->count();

        for($i = 1; $i <=$user_id_count; $i++){
            $event_count_per_user = rand(2, 6);
            $faker = Factory::create();
            for($j = 1; $j <= $event_count_per_user; $j++){
                DB::table("user_event_mappings")->insert([
                    'user_id' => rand(1, $user_id_count),
                    'event_id' => rand(1, $event_id_count),
                    'notes' => $faker->words(3, true),
                ]);
            }
        }
    }
}
