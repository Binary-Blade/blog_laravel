<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
       return Category::all();
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
    public function show( Category $category): Category
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): Category
    {
        $category->update($request->validate([
            "name"=> "sometimes|string|max:50",
        ]));
        return $category;
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
