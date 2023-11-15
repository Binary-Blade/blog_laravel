<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Article::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "title" => 'required|string|max:50',
            "full_text" => 'nullable|string',
            "image_path" => 'nullable|image',
        ]);

        $validatedData['user_id'] = 1;
        $validatedData['category_id'] = $request->route('category');

        return Article::create($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, Article $article): Article
    {
        return $article;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, Article $article): Article
    {
        $article->update($request->validate([
            "title" => 'sometimes|string|max:50',
            "full_text" => 'nullable|string',
            "image_path" => 'nullable|image',
        ]));
        return $article;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Article $article)
    {
        $article->delete();

        return response(status: 204);
    }
}
