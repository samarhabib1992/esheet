<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['attachment_name', 'attachment_path', 'attachment_type', 'attachment_size', 'attachable_type', 'attachable_id'];

    /**
     * Get the owning attachable model (product, category, or user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachable()
    {
        return $this->morphTo();
    }
}
