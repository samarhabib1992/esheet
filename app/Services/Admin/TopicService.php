<?php

namespace App\Services\Admin;
use Exception;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Repositories\Interfaces\TopicRepositoryInterface;


class TopicService extends BaseService implements TopicRepositoryInterface
{
    protected $topicRepository;

    /**
     * Initializes the CategoryRepositoryInterface with the required dependencies.
     *
     */
    public function __construct(TopicRepositoryInterface $topicRepository) 
    {
        $this->setRepository($topicRepository);
    }
    public function getAll()
    {
        $columns  = ['id', 'name','product_type_id','category_id'];
        $conditions = [
        ];
        $relations = [
            'productType' => function($query) {
                $query->select(['id', 'name']);
            },
            'category' => function($query) {
                $query->select(['id', 'name']);
            }
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
                    'category_id' => $data['category_id'],
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
                    'name' => $data['name'],
                    'product_type_id' => $data['product_type_id'],
                    'category_id' => $data['category_id'],
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

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $columns = ['*'];
            $relations = [];
            $conditions = [
                'id' => $id
            ];
            $topic = $this->repository->findRecord($columns,$relations,$conditions);
            if($topic) {
                $topic->delete();
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

    public function getTopicsByCategory($category_id = null){
        if(empty($category_id)){
            return [
                'statusCode' => 429,
                'message' => 'Please select a product type first',
            ];
        } 
        $conditions = [
            'category_id' => $category_id,
            'status' => 1
        ];
        $columns = ['id', 'name'];
        $response = $this->repository->findRecords($conditions, $columns);
        if ($response) {
            return [
                'statusCode' => 200,
                'data' => $response,
                'message' => 'Topics fetched successfully',
            ];
        } else {    
            return [
                'statusCode' => 200,
                'message' => 'No topic exists for this category.',
            ];
        }
    }
}
