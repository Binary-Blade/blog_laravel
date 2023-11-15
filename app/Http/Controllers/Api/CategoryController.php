<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Class CategoryController
 *
 * Handles HTTP requests related to Category resources.
 */
class CategoryController extends Controller
{
    use CanLoadRelationships;

    protected array $relations = ['user', 'articles', 'articles.user', 'articles.tags'];
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection Returns a collection of Category resources.
     */
    public function index(): AnonymousResourceCollection
    {
        // Initialize the query builder for Category model
        $query = $this->loadRelationships(Category::query());

        // Return paginated and sorted collection of categories
        return CategoryResource::collection(
            $query->latest()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request The request object containing the data.
     * @return CategoryResource The newly created Category object.
     */
    public function store(Request $request): CategoryResource
    {
        // Validate and retrieve the request data
        $category = Category::create([
            $request->validate([
            "name" => "required|string|max:50",
        ]),
            'user_id' => 1,
        ]);

        // Create and return the new category
        return new CategoryResource($this->loadRelationships($category));
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category The category to display.
     * @return CategoryResource Returns the specified Category resource.
     */
    public function show(Category $category): CategoryResource
    {
        // Load related articles for the category
        return new CategoryResource($this->loadRelationships($category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request The request object containing the data.
     * @param Category $category The category to update.
     * @return CategoryResource Returns the updated Category resource.
     */
    public function update(Request $request, Category $category): CategoryResource
    {
        // Validate the request data and update the category
        $category->update($request->validate([
            "name" => "sometimes|string|max:50",
        ]));
        return new CategoryResource($this->loadRelationships($category));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category The category to delete.
     * @return Response Returns an HTTP response with status code.
     */
    public function destroy(Category $category): Response
    {
        // Delete the specified category
        $category->delete();

        // Return a 204 No Content response
        return response(status: 204);
    }
}
