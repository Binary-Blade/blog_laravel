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
        // Create a single user with predefined credentials.
        $user = User::factory()->createOne([
            'name' => 'Valou Test',
            'email' => 'houvillev@gmail.com',
            'password' => bcrypt('admin2222'),
        ]);

        // Create three categories and associate them with the created user.
        // The 'for' method sets the foreign key on the related model.
        $categories = Category::factory()->count(3)->for($user)->create();

        // Iterate over each category to create articles.
        $categories->each(function ($category) use ($user) {
            // Create 10 articles for each category, associating them with the category and the user.
            $articles = Article::factory(10)->create([
                'category_id' => $category->id,
                'user_id' => $user->id,
            ]);

            // Iterate over each article to associate tags.
            $articles->each(function ($article) {
                // Attach 3 tags to each article. Tags are created here and associated with the user.
                // The 'pluck' method collects the IDs of the created tags to be used in the 'attach' method.
                $article->tags()->attach(
                    Tag::factory()->count(3)->create(['user_id' => $article->user_id])->pluck('id')
                );
            });
        });
    }

}
