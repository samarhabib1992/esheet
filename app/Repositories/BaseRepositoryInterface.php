<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
/**
 * Attendance Repository Interface to make repository abstract
 */
interface BaseRepositoryInterface
{

    /**
    * @param null
    * @return model
    */
    public function getModel();
    /**
    * @param model
    * @return $this
    */
    public function setModel(Model $model);

    /**
    * @param $query (Model)
    * @param array $sort
    * @return ?Model
    */
    public function setSort($query, array $sort = []);
    /**
    * @param array $columns
    * @param array $relations
    * @return collections
    */
    public function all(array $columns = ['*'], array $relations = [],array $orderBy = [], array $conditions = []): Collection;
     /**
    * @param array $columns
    * @param array $relations
    * @return \Illuminate\Pagination\Paginator
    */
    public function all_paginate(array $columns = ['*'], array $relations = [],array $orderBy = [],$per_page = 0, Array $conditions = []);
    /**
    * @param $data array
    * @return Illuminate\Database\Eloquent\Model
    */
    public function create(array $data): Model;

    /**
    * @param 1. data array 2. record id
    * @return Bolean (true/false)
    */
    public function update(array $data, $id): Model;

    /**
    * @param $id (record id)
    * @return boolean
    */
    public function delete($id): bool;

    /**
    * @param string $field
    * @param Array $ids
    * @return boolean
    */
    public function deleteWhereIn(string $field, Array $ids);
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
    ): ?Model;

    /**
    * @param array $columns
    * @param array $relations
    * @param: array $conditions
    * @return ?Model
    */
    public function findRecord(
        array $columns = ['*'],
        array $relations = [],
        array $conditions = [],
        array $count_relation = []
    ): ?Model;
    /**
    * @param relation names,$id
    * @return models with relations
    */
    public function with($relations,$id);
    /**
    * @param null
    * @return attributes (model attributes)
    */
    public function fillables();
    /**
     * insert batch data
     * @param: $data Array
     * @return: Mix
     */
    public function batchInsert($data = array());

    /**
    * @param $column
    * @param array $values
    * @param array $relations
    * @param array $columns
    * @param array $relations
    * @return collections
    */
    public function getRecordsByColumn($column,array $values = [],
                        array $conditions = [], array $columns = ['*'], array $relations = [], array $orderBy = [], array $groupBy = []): Collection;



    public function getRecordsByColumnWithTrash($column,array $values = [],
    array $conditions = [], array $columns = ['*'], array $relations = [], array $orderBy = [], array $groupBy = []): Collection;
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
    public function deleteData($field_name,$field_value, array $conditions = []): bool;

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
    public function getRecordsByColumnWithPagination($column,array $values = [],
                            array $conditions = [],array $columns = ['*'], array $relations = [],$per_page = 50);

    /**
    * @param conditions $conditions
    * @param array $columns
    * @param array $relations
    * @param array $orderBy
    * @return collection
    */
    public function findRecords(
        array $conditions = [],
        array $columns = ['*'],
        array $relations = [],
        array $orderBy = [],
        array $whereHas = [],
    ): collection;

    public function findRecordsByPagination(array $conditions = [], array $columns = ['*'],array $relations = [],array $orderBy = [],$per_page = 50,array $count_relation = []);

    /**
    * @param Array conditions
    * @param Array data
    * @return boolean
    */
    public function updateWhereCondition(array $condition = [], array $data = [],$whereRaw = '');
    
     /**
    * @param 1. sting field , 2. ids  array 3. data array
    * @return Bolean (true/false)
    */
    public function updateWhereIn(string $field,array $id , array $data);

}
