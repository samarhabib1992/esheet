<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'category_id', 'product_type_id', 'status'];

    /**
     * Get the category that the topic belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the product type that the topic belongs to.
     */
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}
