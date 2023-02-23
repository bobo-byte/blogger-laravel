<?php

namespace Database\Seeders;

use App\Models\{Topic,Post};
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Topic::factory()
            ->hasAttached(Post::factory()->count(3))
            ->create();
    }
}
