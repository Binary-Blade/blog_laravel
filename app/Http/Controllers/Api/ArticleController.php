<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return ArticleResource::collection(Article::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): ArticleResource
    {
        $validatedData = $request->validate([
            "title" => 'required|string|max:50',
            "full_text" => 'nullable|string',
            "image_path" => 'nullable|image',
        ]);

        $validatedData['user_id'] = 1;
        $validatedData['category_id'] = $request->route('category');

        return new ArticleResource(Article::create($validatedData));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, Article $article): ArticleResource
    {
        return new ArticleResource($article);
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
