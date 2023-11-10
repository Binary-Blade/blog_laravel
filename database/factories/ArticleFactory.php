<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = fake()->dateTimeBetween('-2 years');
        return [
            'title'=> fake()->sentence(3),
            'full_text'=>fake()->paragraph(),
            'image_path'=>fake()->url(),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'created_at' => $createdAt,
            'updated_at'=>fake()->dateTimeBetween($createdAt, 'now'),
        ];
    }
}
