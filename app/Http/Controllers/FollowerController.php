<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    public function toggleFollow(User $user)
    {
        // Must import \Facades\Auth to use Auth::user(). auth()->user() works in Blade because it is automatically accessible
        // Toggles whether Auth::user() (CURRENT USER) follows another user ($user)
        $user->followers()->toggle(Auth::user());

        // Returns the other user's follower count to be displayed.
        return response()->json(["followers" => $user->followers()->count()]);
    }
}
