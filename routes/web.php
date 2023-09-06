<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;

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
    Route::group(['middleware' => ['auth', 'verified']], function () {
        Route::get('/create', 'create')->name('create');
        Route::delete('/delete/{article}', 'delete')->name('delete');
        Route::post('/store', 'store')->name('store');
        Route::put('/update/{article}', 'update')->name('update');
    });
    Route::post('/search', 'search')->name('search');
    Route::get('/filter/{category}', 'filterByCategory')->name('filter');
    Route::get('/{id}', 'show')->name('show');
});

// comment routes
Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::resource('comments', CommentController::class)->only('store', 'update', 'destroy');
});

// user routes
Route::put('/user/update-password/{user}', [UserController::class, 'updatePassword'])->name('user.password.update');
Route::resource('user', UserController::class)->except('index', 'create', 'store');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();



// Admin routes
Route::group([
    'controller' => AdminController::class,
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['admin']
], function () {
    Route::get('/panel', 'index')->name('dashboard');
    Route::get('/view-user/{user}', 'showUser')->name('user.show');
    Route::get('/view-user/articles/{article}', 'showArticle')->name('article.show');
    Route::delete('/delete-user/{user}', 'deleteUser')->name('user.destroy');
    Route::delete('/delete-comment/{comment}', 'deleteComment')->name('comment.destroy');
    Route::delete('/delete-article/{article}', 'deleteArticle')->name('article.destroy');
    Route::post('admin-permission/{user}', 'toggleAdmin')->name('user.toggle.admin');
});


// Email Verification Routes

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
