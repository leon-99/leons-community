<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

// article routes
Route::get('/', [ArticleController::class, 'index'])->name('index');


/*
---------------------------------
   Article Routes
---------------------------------
    Using route groups, you can pass in an array of options as the first parmeter.
    Options using in this group:
        controller: pre-declare the controller all routes in this group gonna go, so you only have to write the method name.
        prefix: since all the routes in this group are gonna start with the url 'article', we pre-delcare it as well.
        as: same as the piefic above but for the route names, all the route names in this group are gonna start with 'article.'
*/

Route::group(['controller' => ArticleController::class, 'prefix' => 'articles', 'as' => 'article.'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/create', 'create')->name('create');
        Route::delete('/delete/{article}', 'delete')->name('delete');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{article}', 'update')->name('update');
    });
    Route::post('/search', 'search')->name('search');
    Route::get('/filter/{category}', 'filterByCategory')->name('filter');
    Route::get('/recent', 'recent')->name('recent');
    Route::get('/{article}', 'show')->name('show');
});

// comment routes
Route::resource('comments', CommentController::class)->only('store', 'update', 'destroy')->middleware('auth');

// user routes
Route::put('/user/update-password/{user}', [UserController::class, 'updatePassword'])->name('user.password.update');
Route::resource('user', UserController::class)->except('index', 'create', 'store');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
