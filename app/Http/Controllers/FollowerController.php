<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function toggleFollow(User $user)
    {
        // auth()->user() works in Blade because it is automatically accessible
        // Toggles whether Auth::user() (CURRENT USER) follows another user ($user)
        $user->followers()->toggle(Auth::user());

        // Returns the other user's follower count to be displayed.
        return response()->json([
            "followerCount" => $user->followers()->count()
        ]);
    }
}
