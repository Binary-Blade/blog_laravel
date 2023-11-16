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
 * This route is protected by Sanctum and returns the authenticated user.
 */
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * These routes provide public access for all users.
 * They allow users to view categories, articles, and tags.
 */
Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show']);
Route::apiResource('categories.articles', ArticleController::class)
    ->scoped()->only(['index', 'show']);
Route::apiResource('tags', TagController::class)
    ->only(['index', 'show']);

/**
 * This route is used for user authentication.
 * It should be outside the Sanctum middleware group to allow unauthenticated users to login.
 */
Route::post('login', [AuthController::class, 'login']);

/**
 * These routes are protected by Sanctum and provide content management (store, update, destroy).
 * They allow authenticated users to perform these operations on categories, articles, and tags.
 */
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('categories', CategoryController::class)
        ->except(['index', 'show']);
    Route::apiResource('categories.articles', ArticleController::class)
        ->except(['index', 'show']);
    Route::apiResource('tags', TagController::class)
        ->except(['index', 'show']);
});
