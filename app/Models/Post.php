<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

// implements HasMedia for using Spatie Media Library
class Post extends Model implements HasMedia
{
    use HasFactory;
    // use InteractsWithMedia for using Spatie Media Library
    use InteractsWithMedia;

    protected $fillable = [
        "title",
        "content",
        "category_id",
        "slug",
        "user_id",
        "published_at"
    ];

    // Import Media
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            // addMediaConversion("name") determines the name to call image
            ->addMediaConversion('preview')
            ->width(400);
        // Without nonQueued() conversion happens in the background (in the queue)
        // ->nonQueued();

        $this->addMediaConversion("large")->width(1200);
    }

    // Get User relationship data
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function readTime($wordsPerMinute = 100)
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / $wordsPerMinute);

        return max(1, $minutes);
    }

    // "" is the original file size
    public function imageUrl($conversionName = "")
    {
        // getFirstMedia()->getUrl() is from spatie. getUrl() or getUrl("preview") determines the image type to return.
        return $this->getFirstMedia()->getUrl($conversionName);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
