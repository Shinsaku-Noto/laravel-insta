<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::group(["middleware" => "auth"], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
    Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
    Route::get('/see-all', [App\Http\Controllers\HomeController::class,'seeAll'])->name('see.all');

    Route::get('/profile/edit/{id}', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/follower/{id}', [App\Http\Controllers\ProfileController::class, 'follower'])->name('profile.follower');
    Route::get('/profile/following/{id}', [App\Http\Controllers\ProfileController::class, 'following'])->name('profile.following');

    Route::get('/admin/users/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/posts/', [App\Http\Controllers\Admin\PostsController::class, 'index'])->name('admin.posts');
    Route::get('/admin/categories/', [App\Http\Controllers\Admin\CategoriesController::class, 'index'])->name('admin.categories');

    Route::resource('/post', PostController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/comment', CommentController::class);
    Route::resource('/profile', ProfileController::class)->except('edit');
    Route::resource('/like', LikeController::class);
    Route::resource('/follow', FollowController::class);
});
