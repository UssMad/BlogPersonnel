<?php

namespace App\Models;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'category_id',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the user (author) that owns the article.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that the article belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Calculate the estimated reading time based on word count.
     * Average reading speed: ~200 words per minute.
     */
    public function getReadingTimeAttribute(): string
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = max(1, (int) ceil($wordCount / 200));

        return $minutes . ' min read';
    }

    /**
     * Get a short excerpt of the article content.
     */
    public function getExcerptAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->content), 180);
    }
}
