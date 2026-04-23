<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'status',
        'published_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
