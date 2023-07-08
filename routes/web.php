<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

Route::controller(ArticleController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/articles', 'index');
    Route::get('/articles/detail/{article}', 'detail');
    // named route, can be called using route() function on the a tag's href link.
    Route::get('/articles/delete/{article}', 'delete')->name('article-delete');
    Route::get('/articles/add', 'add')->name('article-add');
    Route::post('/articles/add', 'create');
    Route::get('/articles/edit/{article}', 'edit');
    Route::post('/articles/edit/{article}', 'update');
});




// grouping all the routes that goes to the same controller
Route::controller(CommentController::class)->group(function () {
    Route::post('/comments/add', 'create');
    Route::get('comments/delete/{id}', 'delete');
    Route::get('comments/edit/{id}', 'edit');
    Route::post('comments/edit/{id}', 'update');
});

Route::controller(UserController::class,)->group(function() {
    Route::get('/user/view/{id}', 'show');
    Route::get('/user/edit/{id}', 'edit');
    Route::post('/user/edit/{id}', 'update');
    Route::post('/user/delete/{id}', 'delete');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
