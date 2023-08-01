<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

// article routes
Route::get('/', [ArticleController::class, 'index'])->name('index');

Route::group(['controller' => ArticleController::class, 'prefix' => 'articles'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/create', 'create')->name('article.create');
        Route::delete('/delete/{article}', 'delete')->name('article.delete');
        Route::post('/store', 'store')->name('article.store');
        Route::put('/update/{article}', 'update')->name('article.update');
    });
    Route::post('/search', 'search')->name('article.search');
    Route::get('/{article}', 'show')->name('article.show');
});

// comment routes
Route::resource('comments', CommentController::class)->only('store', 'update', 'destroy');

// user routes
Route::put('/user/update-password/{user}', [UserController::class, 'updatePassword'])->name('user.password.update');
Route::resource('user', UserController::class)->except('index', 'create', 'store');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
