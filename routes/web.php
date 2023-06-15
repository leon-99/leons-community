<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;



Route::get('/', [ArticleController::class, 'index']);

Route::get('/articles', [ArticleController::class, 'index']);

Route::get('/articles/detail/{id}', [ArticleController::class, 'detail']);

Route::get('/articles/delete/{id}', [ArticleController::class, 'delete'])->name('article-delete');

// named route, can be called using route() function on the a tag's href link.
Route::get('/articles/add', [ArticleController::class, 'add'])->name('article-add');

Route::post('/articles/add', [ArticleController::class, 'create']);

Route::get('/articles/edit/{id}', [ArticleController::class, 'edit']);
Route::post('/articles/edit/{id}', [ArticleController::class, 'update']);


// grouping all the routes that goes to the same controller
Route::controller(CommentController::class)->group(function () {
    Route::post('/comments/add', 'create');
    Route::get('comments/delete/{id}', 'delete');
    Route::get('comments/edit/{id}', 'edit');
    Route::post('comments/edit/{id}', 'update');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
