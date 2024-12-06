<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([   
            UserSeeder::class,
            TagSeeder::class,
            EventCategorySeeder::class,
            OrganizerSeeder::class,
            EventSeeder::class,
            EventEventCategoryMappingSeeder::class,
            EventTagMappingSeeder::class,
            BookingSeeder::class,
            // BookmarkSeeder::class,
            RoleSeeder::class,
            // UserTagMappingSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
