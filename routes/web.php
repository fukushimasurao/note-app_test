<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// 投稿フォーム表示
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

// 記事詳細
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// 投稿処理
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// 編集フォーム表示
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');

// 更新処理
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

// 削除処理
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');