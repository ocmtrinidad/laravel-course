<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        $hasLiked = $post->likes()->where("user_id", Auth::user()->id)->exists();
        if (!$hasLiked) {
            $post->likes()->create([
                "user_id" => Auth::user()->id
            ]);
        } else {
            $post->likes()->where("user_id", Auth::user()->id)->delete();
        }

        return response()->json([
            "likesCount" => $post->likes()->count()
        ]);
    }
}
