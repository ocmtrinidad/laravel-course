<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [PostController::class, "index"])
    ->name('dashboard');

// Calls show(string username, Post post)
// post:slug means url will display slug
Route::get("/@{username}/{post:slug}", [PostController::class, "show"])->name("post.show");

Route::middleware(["auth", "verified"])->group(function () {
    Route::get("/post/create", [PostController::class, "create"])
        ->name("post.create");
    Route::post("/post/create", [PostController::class, "store"])
        ->name("post.store");

    Route::get("/category/{category:name}", [PostController::class, "category"])->name("post.byCategory");

    Route::post("/follow/{user}", [FollowerController::class, "toggleFollow"])->name("follow");

    Route::post("/like/{post}", [LikeController::class, "like"])->name("like");
});

Route::get("/@{user:username}", [PublicProfileController::class, "show"])->name("profile.show");


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
