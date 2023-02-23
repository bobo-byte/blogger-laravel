<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Post, Topic};

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //hasAttached assign's values to pivot table
        Post::factory()
            ->count(3)
            ->hasAttached(
                Topic::factory()->count(3))
            ->create();
    }
}
