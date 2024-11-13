<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelusers;

class UserTagMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_id_count = User::get()->count();
        $tag_id_count = Tag::get()->count();

        for($i = 1; $i <=$user_id_count; $i++){
            $tag_count_per_user = rand(2, 6);
            $faker = Factory::create();
            for($j = 1; $j <= $tag_count_per_user; $j++){
                DB::table("user_tag_mappings")->insert([
                    'user_id' => rand(1, $user_id_count),
                    'tag_id' => rand(1, $tag_id_count),
                    'notes' => $faker->words(3, true),
                ]);
            }
        }
    }
}
