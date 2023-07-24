<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

// article routes
Route::controller(ArticleController::class)->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/articles/create', 'create')->name('article.create');
        Route::delete('/articles/delete/{article}', 'delete')->name('article.delete');
        Route::post('/articles/store', 'store')->name('article.store');
        Route::post('/articles/edit/{article}', 'update')->name('article.update');
    });

    Route::get('/', 'index')->name('index');
    Route::get('/articles/{article}', 'show')->name('article.show');
});

// comment routes
Route::resource('comments', CommentController::class)->only('store', 'update', 'destroy');

// user routes
Route::put('/user/update-password/{user}', [UserController::class, 'updatePassword'])->name('user.password.update');
Route::resource('user', UserController::class)->except('index', 'create', 'store');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
