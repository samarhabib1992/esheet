<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'product_type_id', 'status'];

    /**
     * Get the product type associated with the category.
     */
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
