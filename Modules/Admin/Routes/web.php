<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\AdminPostController;
use Modules\Admin\Http\Controllers\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->middleware('checkAdmin')->group(function() {

    Route::get('/panel', [AdminController::class, 'index'])->name('admin.panel');

    Route::resource('/users', AdminUserController::class);
    Route::get('/users-data', [AdminUserController::class, 'data'])->name('users.data');
    
    Route::resource('/posts', AdminPostController::class);
    Route::get('/posts-data', [AdminPostController::class, 'data'])->name('posts.data');
    Route::post('/activate/posts/{post}', [AdminPostController::class, 'activate'])->name('posts.activate');

    Route::resource('/categories', AdminCategoryController::class);
    Route::get('/categories-data', [AdminCategoryController::class, 'data'])->name('categories.data');

    Route::resource('/tags', AdminTagController::class);
    Route::get('/tags-data', [AdminTagController::class, 'data'])->name('tags.data');
});
