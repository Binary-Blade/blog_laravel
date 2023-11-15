<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;


/**
 * Class ArticleController
 *
 * Handles HTTP requests related to Article resources within a specific Category.
 */
class ArticleController extends Controller
{
    use CanLoadRelationships;

    protected array $relations = ['tags', 'user'];
    /**
     * Display a listing of articles for a given category.
     *
     * @param Category $category The category for which articles are to be listed.
     * @return AnonymousResourceCollection Collection of articles in the specified category.
     */
    public function index(Category $category): AnonymousResourceCollection
    {
        // Retrieve latest articles for the given category
        $articles = $this->loadRelationships(
            $category->articles()->latest()
            );

        // Return paginated collection of articles
        return ArticleResource::collection(
            $articles->paginate()
        );
    }

    /**
     * Store a newly created article in storage.
     *
     * @param Request $request The request object containing the article data.
     * @return ArticleResource The newly created Article resource.
     */
    public function store(Request $request): ArticleResource
    {
        // Validate the request data
        $validatedData = $request->validate([
            "title" => 'required|string|max:50',
            "full_text" => 'nullable|string',
            "image_path" => 'nullable|image',
        ]);

        // Manually setting the user_id and category_id for the article
        $validatedData['user_id'] = 1;
        $validatedData['category_id'] = $request->route('category');
        $articles = Article::create($validatedData);

        // Create and return the new article
        return new ArticleResource($this->loadRelationships($articles));
    }

    /**
     * Display the specified article.
     *
     * @param Category $category The category of the article.
     * @param Article $article The article to display.
     * @return ArticleResource The specified Article resource.
     */
    public function show(Category $category, Article $article): ArticleResource
    {
        // Load related user data for the article
        return new ArticleResource($this->loadRelationships($article));
    }

    /**
     * Update the specified article in storage.
     *
     * @param Request $request The request object containing the updated data.
     * @param Category $category The category of the article.
     * @param Article $article The article to update.
     * @return ArticleResource The updated Article object.
     */
    public function update(Request $request, Category $category, Article $article): ArticleResource
    {
        // Validate the request data and update the article
        $article->update($request->validate([
            "title" => 'sometimes|string|max:50',
            "full_text" => 'nullable|string',
            "image_path" => 'nullable|image',
        ]));
        return new ArticleResource($this->loadRelationships($article));
    }

    /**
     * Remove the specified article from storage.
     *
     * @param Category $category The category of the article.
     * @param Article $article The article to delete.
     * @return Response Returns an HTTP response with status code.
     */
    public function destroy(Category $category, Article $article): Response
    {
        // Delete the specified article
        $article->delete();

        // Return a 204 No Content response
        return response(status: 204);
    }
}
