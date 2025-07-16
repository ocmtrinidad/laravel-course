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

        // paginate uses /views/vendor/pagination/tailwind.blade.php
        $posts = Post::orderBy("created_at", "desc")->paginate(5);
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
        // Image needs to be processed before creating Post.
        $image = $data["image"];
        // store("FOLDER", "DISC"). Use php artisan storage:link.
        // USE CLOUDINARY INSTEAD THEN STORE CLOUDINARY LINK TO DATABASE.
        $imagePath = $image->store("posts", "public");
        // Add new image path to $data.
        $data["image"] = $imagePath;

        Post::create($data);
        return redirect()->route("dashboard");
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
