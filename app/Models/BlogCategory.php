<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status'];
     // A category can have many blogs
     public function blogs()
     {
         return $this->hasMany(Blog::class);
     }
    
}
