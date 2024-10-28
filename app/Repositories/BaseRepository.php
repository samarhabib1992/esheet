<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseRepository implements BaseRepositoryInterface
{
    // model property on class instances
    protected $model;

    /**
     * @desc: injecting model to base repository
     * @param eloquent $model
     */

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
     * @param null
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param Model
     * @return $this
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }
    /**
     * @param $query (Model)
     * @param array $sort
     * @return ?Model
     */
    public function setSort($query, array $sort = [])
    {
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }
        return $query;
    }
    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = [], array $orderBy = [], array $conditions = [], array $count_relation = [], bool $trashIncluded = false): Collection
    {
        $result = "";
        $query =  $this->model->with($relations);
        if (is_array($count_relation) && count($count_relation) > 0) {
            $query = $query->withCount($count_relation);
        }
        if (is_array($conditions) && count($conditions) > 0)
            $query = $query->where($conditions);
        if (is_array($orderBy) && count($orderBy) > 0)
            $query = $this->setSort($query, $orderBy);

        if ($trashIncluded) {
            //info("incudluing trash");
            $result = $query->withTrashed()->get($columns);
        } else {
            //info("excludeding trash");
            $result = $query->get($columns);
        }

        return $result;
    }

    /**
     * @param array $columns
     * @param array $relations
     * @return
     */
    public function all_paginate(array $columns = ['*'], array $relations = [], array $orderBy = [], $per_page = 0, array $conditions = [], array $count_relation = [], $orderRaw = '')
    {
        $result = "";
        $query =  $this->model->select($columns);
        if (is_array($conditions) && count($conditions) > 0)
            $query = $query->where($conditions);
        if (is_array($orderBy) && count($orderBy) > 0)
            $query = $this->setSort($query, $orderBy);
        if ($orderRaw != "")
            $query = $query->orderByRaw($orderRaw);

        $query = $query->with($relations);
        if (is_array($count_relation) && count($count_relation) > 0) {
            $query = $query->withCount($count_relation);
        }
        if ($per_page > 0)
            $result = $query->paginate($per_page, $columns);
        else
            $result = $query->get($columns);
        return $result;
    }

    /**
     * @param $data array
     * @return model
     */
    public function create(array $data): Model
    {
        $model = $this->model->create($data);
        return $model->fresh();
    }

    /**
     * @param 1. data array 2. record id
     * @return Model
     */
    public function update(array $data, $id): Model
    {
        $record = $this->model->find($id);
        $record->update($data);
        return $record;
    }

    /**
     * @param Array conditions
     * @param Array data
     * @return boolean
     */
    public function updateWhereCondition(array $condition = [], array $data = [], $whereRaw = '')
    {
        if (count($condition) > 0 && count($data) > 0) {
            $query = $this->model->where($condition);
            if ($whereRaw != '')
                $query = $query->whereRaw($whereRaw);
            return $query->update($data);
        }
    }

    /**
     * @param $id (record id)
     * @return boolean
     */
    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }

    /**
     * @param string $field
     * @param Array $ids
     * @return boolean
     */
    public function deleteWhereIn(string $field, array $ids): bool
    {
        return $this->model->whereIn($field, $ids)->delete();
    }

    /**
     * @param record $id
     * @param array $columns
     * @param array $relations
     * @param: array $appends
     * @return Model
     */
    public function show(
        $id,
        array $columns = ['*'],
        array $relations = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->find($id);
    }


    /**
     * @param array $columns
     * @param array $relations
     * @param: array $conditions
     * @return Model
     */
    public function findRecord(
        array $columns = ['*'],
        array $relations = [],
        array $conditions = [],
        array $count_relation = [],
        string $whereRaw = ''
    ): ?Model {
        $query = $this->model->select($columns);
        if (is_array($conditions) && count($conditions) > 0)
            $query = $query->where($conditions);
        if ($whereRaw != '')
            $query = $query->whereRaw($whereRaw);
        if (is_array($count_relation) && count($count_relation) > 0) {
            $query = $query->withCount($count_relation);
        }
        return $query->with($relations)->first();
    }

    /**
     * @param array $columns
     * @param array $relations
     * @param: array $conditions
     * @return Model
     */
    public function findRecordCount(
        array $columns = ['*'],
        array $conditions = []
    ) {
        $query = $this->model->select($columns);
        if (is_array($conditions) && count($conditions) > 0)
            $query = $query->where($conditions);
        return $query->count();
    }

    /**
     * @param relation names, $id
     * @return models with relations
     */
    public function with($relations, $id): Model
    {
        return $this->model->with($relations)->find($id);
    }
    /**
     * @param null
     * @return attributes (model attributes)
     */
    public function fillables()
    {
        return $this->model->getFillables();
    }
    public function batchInsert($data = array())
    {
        return $this->model->insert($data);
    }
    /**
     * @param $column
     * @param array $values
     * @param array $conditions [['field','=','value'],['field2','=','value2']]
     * @param array $relations
     * @param array $columns
     * @param array $relations
     * @return collections
     */
    public function getRecordsByColumn(
        $column,
        array $values = [],
        array $conditions = [],
        array $columns = ['*'],
        array $relations = [],
        array $orderBy = [],
        array $groupBy = []
    ): Collection {
        $query = $this->model->select($columns)->whereIn($column, $values);
        if (is_array($conditions) && count($conditions) > 0)
            $query = $query->where($conditions);
        if (is_array($groupBy) && count($groupBy) > 0)
            $query = $query->groupBy($groupBy);
        if (is_array($orderBy) && count($orderBy) > 0)
            $query = $this->setSort($query, $orderBy);
        return $query->with($relations)->get();
    }


    public function getRecordsByColumnWithTrash(
        $column,
        array $values = [],
        array $conditions = [],
        array $columns = ['*'],
        array $relations = [],
        array $orderBy = [],
        array $groupBy = []
    ): Collection {
        $query = $this->model->select($columns)->whereIn($column, $values)->withTrashed();
        if (is_array($conditions) && count($conditions) > 0)
            $query = $query->where($conditions);
        if (is_array($groupBy) && count($groupBy) > 0)
            $query = $query->groupBy($groupBy);
        if (is_array($orderBy) && count($orderBy) > 0)
            $query = $this->setSort($query, $orderBy);
        return $query->with($relations)->get();
    }

    /**
     * @summary: delete all data of a table by the given field name and value
     * @param: $field_name
     * @param: $field_value ($id)
     * @return: boolean (true/false)
     * @author: Gulzade
     * @date February 1 2021
     * @last_updated_By
     * @last_updated_Date
     */
    public function deleteData($field_name, $field_value, array $conditions = []): bool
    {
        $query = $this->model->where($field_name, $field_value);
        if (is_array($conditions) && count($conditions) > 0)
            $query = $query->where($conditions);
        return $query->delete();
    }

    /**
     * @param $column
     * @param array $values
     * @param array $conditions [['field','=','value'],['field2','=','value2']]
     * @param array $relations
     * @param array $columns
     * @param array $relations
     * @param array $per_page (default 50)
     * @return \Illuminate\Pagination\Paginator
     */
    public function getRecordsByColumnWithPagination(
        $column,
        array $values = [],
        array $conditions = [],
        array $columns = ['*'],
        array $relations = [],
        $per_page = 50
    ) {
        //DB::connection()->enableQueryLog();
        $query = $this->model->whereIn($column, $values);
        if (is_array($conditions) && count($conditions) > 0)
            $query = $query->where($conditions);
        $query = $query->with($relations)->paginate($per_page, $columns);
        //dd(DB::getQueryLog());
        return $query;
    }

    /**
     * @param record $id
     * @param array $columns
     * @param array $relations
     * @param: array $orderBY
     * @param array whereHas array   // Example condition format: ['relation' => 'posts', 'attribute' => 'created_at', 'operator' => '>=', 'value' => '2015-01-01 00:00:00']
     * @return collection
     */
    public function findRecords(array $conditions = [], array $columns = ['*'], array $relations = [], array $orderBy = [], array $whereHas = [], string $whereRaw = ''): collection
    {
        $query = $this->model->select($columns);
        if (is_array($conditions) && count($conditions) > 0)
            $query = $query->where($conditions);
        if ($whereRaw != '')
            $query = $query->whereRaw($whereRaw);
        if (is_array($orderBy) && count($orderBy) > 0)
            $query = $this->setSort($query, $orderBy);
        //need to implement if where has condition to filter records if the relation must have at least one record
        if (!empty($whereHas) && count($whereHas) > 0) {
            foreach ($whereHas as $condition) {
                // Example condition format: ['relation' => 'node', 'attribute' => 'in_deleted', 'operator' => '=', 'value' => '0']
                $relation  = $condition['relation'];
                $attribute = $condition['attribute'];
                $operator  = $condition['operator'];
                $value     = $condition['value'];

                $query->whereHas($relation, function ($q) use ($attribute, $operator, $value) {
                    $q->where($attribute, $operator, $value);
                });
            }
        }
        $query = $query->with($relations)->get();
        return $query;
    }

    /**
     * @param record $id
     * @param array $columns
     * @param array $relations
     * @param: array $appends
     * @return Model
     */
    public function findRecordsByPagination(array $conditions = [], array $columns = ['*'], array $relations = [], array $orderBy = [], $per_page = 50, array $count_relation = [])
    {
        $query = $this->model->select($columns);
        if (is_array($conditions) && count($conditions) > 0)
            $query = $query->where($conditions);
        if (is_array($orderBy) && count($orderBy) > 0)
            $query = $this->setSort($query, $orderBy);

        if (is_array($count_relation) && count($count_relation) > 0) {
            $query = $query->withCount($count_relation);
        }

        $query = $query->with($relations)->paginate($per_page)->withQueryString();
        return $query;
    }

    /**
     * @param string $field
     * @param Array $ids
     * @return boolean
     */
    public function updateWhereIn(string $field, array $ids, array $data)
    {
        if (count($ids) > 0 && count($data) > 0) {
            $query = $this->model->whereIn($field, $ids);
            return $query->update($data);
        }
    }

    /**
     * Check if a record exists by given conditions.
     *
     * @param array $conditions
     * @return bool
     */
    public function exists(array $conditions = []): bool
    {
        return $this->model->where($conditions)->exists();
    }
    /**
     * Find a record by its ID or throw a ModelNotFoundException.
     *
     * @param int $id The ID of the record to find.
     * @return \Illuminate\Database\Eloquent\Model The found model instance.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the record with the given ID is not found.
     */
    public function findOrFailRecord(int $id)
    {
        // Attempt to find the record by its ID using the model's findOrFail method.
        return $this->model->findOrFail($id);
    }
    /**
     * Count the number of records that match the given conditions and `whereIn` clauses.
     *
     * This method constructs a query with specified `where` conditions and `whereIn` clauses
     * and returns the total number of matching records.
     *
     * @param array $conditions An associative array of `where` conditions where keys are column names and values are the corresponding values to filter by.
     * @param array $whereIn An associative array where keys are column names and values are arrays of values to be used in `whereIn` clauses.
     * @return int The count of records that match the given conditions and `whereIn` clauses.
     */
    public function countWhereIn(array $conditions = [], array $whereIn = []): int
    {
        $query = $this->model->query();

        // Apply where conditions
        if (!empty($conditions)) {
            foreach ($conditions as $field => $value) {
                $query->where($field, $value);
            }
        }

        // Apply whereIn conditions
        if (!empty($whereIn)) {
            foreach ($whereIn as $field => $values) {
                $query->whereIn($field, $values);
            }
        }

        return $query->count();
    }
    /**
     * Retrieve records that match the given conditions and `whereIn` clauses.
     *
     * This method constructs a query with specified `where` conditions and `whereIn` clauses
     * and returns a collection of records that match the criteria.
     *
     * @param array $conditions An associative array of `where` conditions where keys are column names and values are the corresponding values to filter by.
     * @param array $whereIn An associative array where keys are column names and values are arrays of values to be used in `whereIn` clauses.
     * @return \Illuminate\Support\Collection A collection of records that match the given conditions and `whereIn` clauses.
     */
    public function getWhereIn(array $conditions = [], array $whereIn = []): Collection
    {
        $query = $this->model->query();

        // Apply where conditions
        if (!empty($conditions)) {
            foreach ($conditions as $field => $value) {
                $query->where($field, $value);
            }
        }

        // Apply whereIn conditions
        if (!empty($whereIn)) {
            foreach ($whereIn as $field => $values) {
                $query->whereIn($field, $values);
            }
        }

        return $query->get();
    }

    /**
     * Update multiple records based on conditions and `whereIn` criteria.
     *
     * @param array $data Associative array of columns and their new values.
     * @param array $conditions Associative array of conditions to be used in the `where` clause.
     * @param array $whereIn Associative array where keys are column names and values are arrays of IDs for the `whereIn` clause.
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public function updateMultiple(array $data, array $conditions = [], array $whereIn = []): bool
    {
        // Start the query builder with the model
        $query = $this->model->query();

        // Apply `where` conditions
        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        // Apply `whereIn` conditions
        foreach ($whereIn as $field => $ids) {
            $query->whereIn($field, $ids);
        }

        // Perform the update
        return $query->update($data);
    }
}
