<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

// Posts routes 

Route::get('/', [PostController::class, 'index'])->name('post.index');
Route::get('/create', [PostController::class, 'create'])->name('post.create');
Route::post('/', [PostController::class, 'store'])->name('post.store');
Route::get('/{slug}/{id}', [PostController::class, 'show'])->name('post.show');
Route::get('/{slug}/edit', [PostController::class, 'edit'])->name('post.edit');
Route::post('/{id}', [PostController::class, 'update'])->name('post.update');
Route::post('/{id}/delete/', [PostController::class, 'destroy'])->name('post.destroy');

// Middleware

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Comments routes

Route::post('/{id}/comment', [CommentsController::class, 'store'])->name('comment.store');