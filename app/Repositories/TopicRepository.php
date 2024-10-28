<?php

namespace App\Repositories;

use App\Models\Topic;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TopicRepositoryInterface;

class TopicRepository extends BaseRepository implements TopicRepositoryInterface
{
    /**
     * @param: $model (eloquent)
     */
    public function __construct(Topic $model)
    {
        parent::__construct($model);
    }
}
