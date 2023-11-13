<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Article;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::all();

        foreach ($articles as $article) {
            $tags = Tag::factory()->count(3)->create(['user_id' => $article->user_id]);
            $article->tags()->attach($tags->pluck('id'));
        }
    }
}

