<?php

namespace App\Repositories;

use Exception;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * @param: $model (eloquent)
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
