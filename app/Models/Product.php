<?php

namespace App\Models;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These attributes can be filled through mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name', 'product_type_id','category_id', 'topic_id', 'price', 'description', 'status'];

    /**
     * Get the category that owns the product.
     * A product belongs to a single category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Get the product type that owns the product.
     * A product belongs to a single product type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo        
     */
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Get the topic that owns the product.
     * A product belongs to a single topic.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    /** 
     * Get all of the product's attachments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
