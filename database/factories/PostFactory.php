<?php

namespace Database\Factories;

use App\Models\{Post, User, Topic};
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->sentence,
            "body" => $this->faker->paragraph("2"),
            "user_id" => User::factory()
        ];
    }
}
