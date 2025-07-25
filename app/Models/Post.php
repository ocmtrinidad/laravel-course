<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

// implements HasMedia for using Spatie Media Library
class Post extends Model implements HasMedia
{
    use HasFactory;
    // use InteractsWithMedia for using Spatie Media Library
    use InteractsWithMedia;
    use HasSlug;

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
        // addMediaConversion("name") determines the name to call image
        $this
            ->addMediaConversion('preview')
            ->width(400);
        // Without nonQueued() conversion happens in the background (in the queue)
        // ->nonQueued();

        $this->addMediaConversion("large")->width(1200);
    }

    // Adds image to default collection then deletes previous related image
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("default")->singleFile();
    }

    /**
     * Get the options for generating the slug.
     */
    // From spatie/laravel-sluggable
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
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

    public function formattedCreatedAt()
    {
        return $this->created_at->format("M d, Y");
    }

    public function formattedPublishedAt()
    {
        return date('F j, Y', strtotime($this->published_at));
    }

    public function checkPublishedAtTime()
    {
        return $this->published_at > now();
    }
}
