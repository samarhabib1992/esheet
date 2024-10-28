<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class BaseService
{
    /**
     * @var repository
     */
    protected $repository;
    protected $http_code = 200;
    /**
     * @param: VehicleRepository  $vehicleRepository;
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * get repositor fillable fields (models)
     */
    public function fillables()
    {
        return $this->repository->fillables();
    }

    /**
     * @desc: find records
     * @return: collections
     */
    public function findRecord($id,$columns=['*'],$relation=[])
    {
        return $this->repository->show($id, $columns, $relation);
    }

    /**
     * @desc: find record
     * @return: collections
     */
    public function findRecordByCondition(array $conditions = [])
    {
        $columns  = ['*'];
        $relation = [];
        return $this->repository->findRecord($columns, $relation, $conditions);
    }

    /**
     * @desc: get all records with conditions
     * @return: collections
     */
    public function findRecordByConditions(array $conditions = [], array $columns = ['*'], array $relations = [], array $orderBy = [])
    {
        return $this->repository->findRecords($conditions, $columns, $relations, $orderBy);
    }

    /**
     *  update location
     *  @param: int id
     *  @param: Array data
     *  @param: Array hours data
     *  @return Mix < Array, boolean>
     */
    public function updateData(int $id, array $data)
    {
        //check if data provided
        if (is_array($data) && count($data) > 0) {
            DB::beginTransaction();
            try {
                //create record
                $result = $this->repository->update($data, $id);
                DB::commit();
                $this->http_code = 200; //updated
                return [
                    'result'      => $result,
                    'status_code' => $this->http_code
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                $this->http_code = 500;
                return [
                    'result'      => $e->getMessage(),
                    'status_code' => $this->http_code
                ];
            }
        } else {
            return false;
        }
    }
    /**
     * delete a record
     */
    public function deleteRecord($request)
    {
        $id = $request->input('id');
        if ($record = $this->findRecord($id)) {
            $data['in_deleted'] = 1;
            DB::beginTransaction();
            try {
                //delete record
                $result = $this->repository->update($data, $id);
                DB::commit();
                $this->http_code = 204; //deleted
                return [
                    'result'      => $result,
                    'status_code' => $this->http_code
                ];
            } catch (\Exception $e) {
                DB::rollBack();
                $this->http_code = 500;
                return [
                    'result'      => $e->getMessage(),
                    'status_code' => $this->http_code
                ];
            }
        } else {
            $this->http_code = 404;
            return [
                'result'      => 'No records found.',
                'status_code' => $this->http_code
            ];
        }
    }

    /**
     * @desc: find record
     * @return: collections
     */
    public function findRecordbyRelation(array $columns = ['*'],array $conditions = [], array $relations = [])
    {
        return $this->repository->findRecord($columns, $relations, $conditions);
    }
}
