<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;


Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

use App\Http\Controllers\PostController;

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts', [PostController::class, 'store'])->name('posts.store');
Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::delete('posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');


use App\Models\Post;
use Illuminate\Http\Request;

Route::get('/posts/filter', function (Request $request) {
    $query = Post::query();

    // Filter by search query (post name)
    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Filter by author
    if ($request->has('author') && $request->author != '') {
        $query->where('author', $request->author);
    }

    // Filter by date
    if ($request->has('date') && $request->date != '') {
        $query->where('date', $request->date);
    }

    // Get the filtered posts
    $posts = $query->get();

    // Return the posts as a partial view
    return view('posts.table', compact('posts'))->render(); // Return only the table content
});


Route::get('/blog-posts', [BlogController::class, 'index'])->name('frontend.posts.index');
Route::get('/posts/{id}', [BlogController::class, 'show'])->name('posts.show');
