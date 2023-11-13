<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * Run the database seeds.
         */
        $categories = Category::all();

        foreach ($categories as $category) {
            Article::factory()->count(10)->create([
                'category_id' => $category->id,
                'user_id' => $category->user_id,
            ]);
        }
    }
}
