<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // auth()->user() works, intelephense just sees it as an error.
        $user = auth()->user();

        // withCount("likes") returns as likes_count
        $query = Post::with(["user", "media"])->withCount("likes")->latest();

        if ($user) {
            // pluck("") uses a join query (hence users.id) to get ids the current user is following.
            $ids = $user->following()->pluck("users.id");
            $query->whereIn("user_id", $ids);
        }

        // paginate uses /views/vendor/pagination/tailwind.blade.php
        $posts = $query->paginate(5);

        return view("post.index", ["posts" => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        return view("post.create", ["categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();

        // Add user_id to $data.
        $data["user_id"] = Auth::id();
        // Generate slug based on title.
        $data["slug"] = \Illuminate\Support\Str::slug($data["title"]);

        $post = Post::create($data);
        // addMediaFromRequest("name") and toMediaCollection("destination") are from /vendor/spatie/laravel-medialibrary/src/InteractsWithMedia.php.
        // Adds $post->image to a request and adds it to a collection where it is processed by registerMediaConversions().
        $post->addMediaFromRequest("image")->toMediaCollection();

        return redirect()->route("dashboard");
    }

    /**
     * Display the specified resource.
     */
    // Parameters are username and post because route is being called with both values even if were not using $username.
    public function show(string $username, Post $post)
    {
        return view("post.show", ["post" => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }
        $categories = Category::get();

        return view("post.edit", ["post" => $post, "categories" => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCreateRequest $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }
        $data = $request->validated();
        $post->update($data);
        if ($data["image"] ?? false) {
            $post->addMediaFromRequest("image")->toMediaCollection();
        }

        return redirect()->route("myPosts");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            // abort(403) returns forbidden.
            abort(403);
        }
        $post->delete();

        return redirect()->route("dashboard");
    }

    public function category(Category $category)
    {
        $posts = $category->posts()->with(["user", "media"])->withCount("likes")->latest()->paginate(5);

        return view("post.index", ["posts" => $posts]);
    }

    public function myPosts()
    {
        $user = auth()->user();
        $posts = $user->posts()->with(["user", "media"])->withCount("likes")->latest()->paginate(5);

        return view("post.index", ["posts" => $posts]);
    }
}
