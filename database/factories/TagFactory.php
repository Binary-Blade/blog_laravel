<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a 'created_at' date-time
        $createdAt = fake()->dateTimeBetween('-2 years');

        return [
            'name' => fake()->sentence(1),
            'created_at' => $createdAt,
            'updated_at'=>fake()->dateTimeBetween($createdAt, 'now'),
        ];
    }
}
