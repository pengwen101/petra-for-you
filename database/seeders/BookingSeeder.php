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
        $user_id_count = User::count();
        $event_id_count = Event::count();
        $statusOptions = ["not started", "ongoing", "finished"];
        $faker = Factory::create();

        for ($i = 1; $i <= $user_id_count; $i++) {
            $event_count_per_user = rand(5, 10);
            $hasReviewed = false; // Track if the user has already reviewed
            $bookedEvents = []; // Track events that the user has already booked

            for ($j = 1; $j <= $event_count_per_user; $j++) {
                do {
                    $event_id = rand(1, $event_id_count);
                } while (in_array($event_id, $bookedEvents));

                $status = $statusOptions[rand(0, count($statusOptions) - 1)];

                // Only allow a review if the status is "finished" and the user hasn't reviewed yet
                $review = $status === "finished" && !$hasReviewed ? $faker->paragraph() : null;

                // Mark as reviewed if a review is added
                if ($review !== null) {
                    $hasReviewed = true;
                }

                DB::table("bookings")->insert([
                    'user_id' => $i, // Ensure user_id is consistent
                    'event_id' => $event_id,
                    'status' => $status,
                    'review' => $review,
                    'stars' => $review !== null ? rand(1, 5) : null, // Only assign stars if there's a review
                    'payment_url' => $faker->url(),
                    'is_payment_validated' => rand(0, 1),
                ]);

                // Add the event to the list of booked events
                $bookedEvents[] = $event_id;
            }
        }
    }
}
