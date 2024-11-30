<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_id_count = User::get()->count();
        $event_id_count = Event::get()->count();
        $status = ["not started", "ongoing", "finished"];

        for($i = 1; $i <=$user_id_count; $i++){
            $event_count_per_user = rand(2, 6);
            $faker = Factory::create();
            for($j = 1; $j <= $event_count_per_user; $j++){
                DB::table("bookings")->insert([
                    'user_id' => rand(1, $user_id_count),
                    'event_id' => rand(1, $event_id_count),
                    'status' => $status[rand(0, count($status)-1)],
                    'review' => $faker->paragraph(),
                    'stars' => rand(1, 5),
                    'payment_url' => $faker->url(),
                    'is_payment_validated' => rand(0, 1),
                ]);
            }
        }
    }
}
