<?php

namespace App\Repositories;

use Exception;
use App\Models\Category;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * @param: $model (eloquent)
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
