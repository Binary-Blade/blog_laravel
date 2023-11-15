<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $query = Category::query();
        $relations = ['user', 'articles','articles.user'];

        foreach ($relations as $relation){
            $query->when(
                $this->shouldIncludeRelation($relation),
                fn($queries) => $queries->with($relation)
            );
        }

       return CategoryResource::collection(
           $query->latest()->paginate());
    }

    protected function shouldIncludeRelation (string $relation): bool
    {
        $include =  \request()->query('include');
        if(!$include) {
            return false;
        }
        $relations = array_map('trim',explode(',', $include));

        return in_array($relation, $relations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name"=> "required|string|max:50",
        ]);

        $validatedData['user_id'] = 1;

        return Category::create($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show( Category $category): CategoryResource
    {
        $category->load('articles');
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): CategoryResource
    {
        $category->update($request->validate([
            "name"=> "sometimes|string|max:50",
        ]));
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response(status: 204);
    }
}
