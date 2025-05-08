<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('posts.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public routes
Route::get('posts/search', [PostController::class, 'search'])->name('posts.search');
Route::resource('posts', PostController::class)->only(['index', 'show'])->where(['post' => '[0-9]+']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Protected posts routes
    Route::resource('posts', PostController::class)->except(['index', 'show']);
    
    // Comments routes (nested under posts)
    Route::resource('posts.comments', CommentController::class)->only(['store', 'update', 'destroy']);
    Route::post('posts/{post}/comments/{comment}/reply', [CommentController::class, 'reply'])->name('posts.comments.reply');
});

require __DIR__.'/auth.php';
