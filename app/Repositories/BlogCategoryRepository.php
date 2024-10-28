<?php

namespace App\Repositories;

use Exception;
use App\Models\BlogCategory;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BlogCategoryRepositoryInterface;

class BlogCategoryRepository extends BaseRepository implements BlogCategoryRepositoryInterface
{
    /**
     * @param: $model (eloquent)
     */
    public function __construct(BlogCategory $model)
    {
        parent::__construct($model);
    }
}
