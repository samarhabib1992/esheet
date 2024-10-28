<?php

namespace App\Services\Admin;

use Exception;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService extends BaseService implements CategoryRepositoryInterface
{
    protected $categoryRepository;
    /**
     * Initializes the CategoryRepositoryInterface with the required dependencies.
     *
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository) 
    {
        $this->setRepository($categoryRepository);
    }

    public function listing()
    {
        $columns  = ['id', 'name','product_type_id'];
        $conditions = [
        ];
        $relations = [
            'productType' => function($query) {
                $query->select(['id', 'name']);
            },
        ];
        $orderBy = ['created_at' => 'DESC'];
        $perPage = 15;
        return $this->repository->findRecordsByPagination($conditions, $columns,$relations,$orderBy,$perPage);
    }
    public function edit($id=null){
        if(!empty($id)){
            $row = $this->repository->show($id);
            if(!empty($row)){
                return $row;
            }
        }
        return [];
    }
    public function store(array $data = [])
    {
        DB::beginTransaction();
        try {           
            if(!empty($data)){
                 // Prepare data to be created
                 $data = [
                    'name' => $data['name'],
                    'product_type_id' => $data['product_type_id'],
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
                    'name'    => $data['name'],
                    'product_type_id' => $data['product_type_id'],
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

    public function delete($id){
        DB::beginTransaction();
        try {
            $columns = ['*'];
            $relations = [];
            $conditions = [
                'id' => $id
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
    public function getCategoriesByProductType($product_type_id = null){
        if(empty($product_type_id)){
            return [
                'statusCode' => 429,
                'message' => 'Please select a product type first',
            ];
        } 
        $conditions = [
            'product_type_id' => $product_type_id,
            'status' => 1
        ];
        $columns = ['id', 'name'];
        $response = $this->repository->findRecords($conditions, $columns);
        if ($response) {
            return [
                'statusCode' => 200,
                'data' => $response,
                'message' => 'Categories fetched successfully',
            ];
        } else {    
            return [
                'statusCode' => 200,
                'message' => 'No category exists for this product type.',
            ];
        }
    }
}
