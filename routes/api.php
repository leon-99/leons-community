<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleApiController;
use App\Http\Controllers\ApiAuthController;

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

// public routes
Route::get('/articles', [ArticleApiController::class, 'index']);
Route::get('/articles/{id}', [ArticleApiController::class, 'show']);
Route::get('/articles/search/{title}', [ArticleApiController::class, 'search']);
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);


// protected routes
Route::group(["middleware" => ['auth:sanctum']], function() {
    Route::post('/articles', [ArticleApiController::class, 'store']);
    Route::put('/articles/{id}', [ArticleApiController::class, 'update']);
    Route::delete('/articles/{id}', [ArticleApiController::class, 'destroy']);

    Route::post('/logout', [ApiAuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// resource routes, laravel can define them automatically, but can't control the auth.
// Route::apiResource('/articles', ArticleApiController::class);

