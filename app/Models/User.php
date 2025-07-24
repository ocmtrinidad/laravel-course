<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'bio',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->width(128)
            ->crop(128, 128);
    }

    // Adds image to avatar collection then deletes previous related avatar
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("avatar")->singleFile();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Returns list of users this user is following
    public function following()
    {
        // belongsToMany(model, table, sender, receiver)
        return $this->belongsToMany(User::class, "followers", "follower_id", "user_id");
    }

    // Returns list of users this user is followed by
    public function followers()
    {
        return $this->belongsToMany(User::class, "followers", "user_id", "follower_id");
    }

    public function imageUrl()
    {
        // Get image from avatar
        $media = $this->getFirstMedia("avatar");
        if (!$media) {
            return null;
        }
        if ($media->hasGenerastedConversion("avatar")) {
            return $media->getUrl("avatar");
        }
        return $media->getUrl();
    }

    // Checks if $this user (The user whos page were looking at) is followed by $user (logged in user)
    public function isFollowedBy(?User $user)
    {
        // If user is not logged in and authenticated
        if (!$user) {
            return false;
        }
        return $this->followers()->where("follower_id", $user->id)->exists();
    }

    public function hasLiked(Post $post)
    {
        return $post->likes()->where("user_id", Auth::user()->id)->exists();
    }
}
