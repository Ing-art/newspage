<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'headline' => fake()->sentence(),
            'subject' => $this->faker->randomElement([
                'politics', 'society', 'science', 'health', 'sports', 'economy', 'entertainment'
            ]),
            'text' => $this->faker->paragraph(4),
            'created_at' =>'2024-07-10',
            'user_id' =>$this->faker->numberBetween(1,4),
            'published_at'=>'2024-07-11'

        ];
    }
}
