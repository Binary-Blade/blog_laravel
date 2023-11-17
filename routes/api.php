<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * Protected route to get the authenticated user's details.
 * Requires a valid Sanctum token.
 */
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Public routes for general access.
 * These routes allow all users to view categories, articles, and tags without authentication.
 */
Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show']);
Route::apiResource('categories.articles', ArticleController::class)
    ->scoped()->only(['index', 'show']);
Route::apiResource('tags', TagController::class)
    ->only(['index', 'show']);

/**
 * Public route for user authentication.
 * Allows users to log in, receiving a Sanctum token for authenticated actions.
 */
Route::post('login', [AuthController::class, 'login']);

/**
 * Protected routes for content management.
 * These routes are accessible only to authenticated users with a valid Sanctum token.
 * They allow for creating, updating, and deleting categories, articles, and tags.
 */
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class,'logout']);
    Route::apiResource('categories', CategoryController::class)
        ->except(['index', 'show']);
    Route::apiResource('categories.articles', ArticleController::class)
        ->scoped()->except(['index', 'show']);
    Route::apiResource('tags', TagController::class)
        ->except(['index', 'show']);
});
