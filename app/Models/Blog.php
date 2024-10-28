<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title', 'slug', 'author_name', 'image', 'short_description', 'content', 'category_id', 'tags', 'status'
    ];

    // A blog belongs to one category
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}

