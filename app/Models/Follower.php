<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    /** @use HasFactory<\Database\Factories\FollowerFactory> */
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        "user_id",
        "follower_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function follower()
    {
        return $this->belongsTo(User::class);
    }
}
