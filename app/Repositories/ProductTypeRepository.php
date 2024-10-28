<?php

namespace App\Repositories;

use Exception;
use App\Models\ProductType;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\ProductTypeRepositoryInterface;

class ProductTypeRepository extends BaseRepository implements ProductTypeRepositoryInterface
{
    /**
     * @param: $model (eloquent)
     */
    public function __construct(ProductType $model)
    {
        parent::__construct($model);
    }
}
