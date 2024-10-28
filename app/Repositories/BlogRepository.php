<?php

namespace App\Repositories;

use Exception;
use App\Models\Blog;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BlogRepositoryInterface;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    /**
     * @param: $model (eloquent)
     */
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }
}
