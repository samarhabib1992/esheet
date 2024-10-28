<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];
     /**
     * Get the categories associated with the product type.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

