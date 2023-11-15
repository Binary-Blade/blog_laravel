<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Tag::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            "name" => "required|string|max:100"
        ]);
        $validateData['user_id'] = 1;

        return Tag::create($validateData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): Tag
    {
        return $tag;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag): Tag
    {
        $tag->update($request->validate([
            "name" => "sometimes|string|max:100"
        ]));
        return $tag;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response(status: 204);
    }
}
