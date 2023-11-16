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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Public Access for all users
Route::apiResource('categories', CategoryController::class)
    ->only(['index', 'show']);
Route::apiResource('categories.articles', ArticleController::class)
    ->scoped()->only(['index', 'show']);
Route::apiResource('tags', TagController::class)
    ->only(['index', 'show']);

Route::post('login', [AuthController::class, 'login']);
// Protected routes for content management (store, update, destroy)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('categories', CategoryController::class)
        ->except(['index', 'show']);
    Route::apiResource('categories.articles', ArticleController::class)
        ->except(['index', 'show']);
    Route::apiResource('tags', TagController::class)
        ->except(['index', 'show']);
});
