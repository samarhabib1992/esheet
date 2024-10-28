<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @param: $model (eloquent)
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
