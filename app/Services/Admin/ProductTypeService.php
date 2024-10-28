<?php

namespace App\Services\Admin;

use Exception;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\ProductTypeRepositoryInterface;

class ProductTypeService extends BaseService implements ProductTypeRepositoryInterface
{
    protected $productTypeRepositoryInterface;
    /**
     * Initializes the ProductTypeRepositoryInterface with the required dependencies.
     *
     */
    public function __construct(ProductTypeRepositoryInterface $productTypeRepository) 
    {
        $this->setRepository($productTypeRepository);
    }


    public function listing()
    {
        $columns  = ['id', 'name','status'];
        $conditions = [];
        $relations = [];
        $orderBy = ['created_at' => 'DESC'];
        $perPage = 15;
        return $this->repository->findRecordsByPagination($conditions, $columns,$relations,$orderBy,$perPage);
    }
    public function edit($id=null){
        return $this->repository->show($id);
    }
    public function store(array $data = [])
    {
        DB::beginTransaction();
        try {           
            if(!empty($data)){
                 // Prepare data to be created
                 $data = [
                    'name' => $data['name'],
                ];
                $this->repository->create($data);
                DB::commit();
                // Return success response
                return [
                    'statusCode' => 200,
                    'message' => 'Record added successfully.',
                ];
            }
            // Return success response
            return [
                'statusCode' => 429,
                'message' => 'Please refresh the page and try again.',
            ];
        } catch (Exception $e) {
            DB::rollBack();
        // Log the exception
        Log::error("error is: " .$e->getMessage());
        // Return error response if exception occurs
            return [
                'statusCode' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function update(array $data = [], $id = null) 
    {
        DB::beginTransaction();
        try {           
            if(!empty($data) && !empty($id)){
                 // Prepare data to be updated
                $updateData = [
                    'name'    => $data['name']
                ];
                // Perform the update using the repository
                $this->repository->update($updateData, $id);
                DB::commit();
                // Return success response
                return [
                    'statusCode' => 200,
                    'message' => 'Record added successfully.',
                ];
            }
            // Return success response
            return [
                'statusCode' => 429,
                'message' => 'Please refresh the page and try again.',
            ];
        } catch (Exception $e) {
            DB::rollBack();
        // Log the exception
        Log::error("error is: " .$e->getMessage());
        // Return error response if exception occurs
            return [
                'statusCode' => 500,
                'message' => $e->getMessage(),
            ];
        }
    }
    public function delete(array $data=[]){
        DB::beginTransaction();
        try {
            $columns = ['*'];
            $relations = [];
            $conditions = [
                'id' => $data['id']
            ];
            $category = $this->repository->findRecord($columns,$relations,$conditions);
            if($category) {
                $category->delete();
            }
             // Commit transaction
             DB::commit();
            // Return error response if exception occurs
            return [
                'statusCode' => 200,
                'message' => "Record Deleted successfully!",
            ];
        }
        catch (Exception $e) {
            DB::rollBack();
           // Log the exception
           Log::error("error is: " .$e->getMessage());
           // Return error response if exception occurs
            return [
                'statusCode' => 422,
                'message' => $e->getMessage(),
            ];
        }
    }
}
