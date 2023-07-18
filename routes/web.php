<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

Route::controller(ArticleController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/articles', 'index');
    Route::get('/articles/detail/{article}', 'detail')->name('article-detail');
    Route::get('/articles/delete/{article}', 'delete')->name('article-delete');
    Route::get('/articles/add', 'add')->name('article-add');
    Route::post('/articles/add', 'create')->name('article-create');
    Route::post('/articles/edit/{article}', 'update')->name('article-update');
});

// grouping all the routes that goes to the same controller
Route::controller(CommentController::class)->group(function () {
    Route::post('/comments/add', 'create')->name('comment-add');
    Route::get('comments/delete/{id}', 'delete')->name('comment-delete');
    Route::post('comments/edit/{id}', 'update')->name('comment-update');
});

Route::controller(UserController::class,)->group(function() {
    Route::get('/user/view/{id}', 'show')->name('user-show');
    Route::get('/user/edit/{id}', 'edit')->name('user-edit');
    Route::post('/user/edit/{id}', 'update')->name('user-update');
    Route::post('/user/delete/{id}', 'delete')->name('user-delete');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
