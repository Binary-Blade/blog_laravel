<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws Exception
     */
    public function run(): void
    {
        // Create Users
        User::factory(1)->create();

        // Create  Categories
        Category::factory(5)->create();

        // Create Tags
        Tag::factory(20)->create();


        Article::factory(20)->create()->each(function ($article) {
            // Generate random number of tag for each articles
            $numTags = random_int(1, 5);
            // Create tags and get their id with pluck
            $tagsIds = Tag::factory()->count($numTags)->create()->pluck('id');
            // Associate tags to the article in the pivot table
            $article->tags()->attach($tagsIds);
        });


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
