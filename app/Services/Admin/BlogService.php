<?php

namespace App\Services\Admin;

use Exception;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\BlogRepositoryInterface;

class BlogService extends BaseService implements BlogRepositoryInterface
{
    protected $blogRepository;
    /**
     * Initializes the CategoryRepositoryInterface with the required dependencies.
     *
     */
    public function __construct(BlogRepositoryInterface $blogRepository) 
    {
        $this->setRepository($blogRepository);
    }

    public function getAll()
    {
        $columns  = ['*'];
        $conditions = [
        ];
        $relations = [
            'category'
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
                    'title' => $data['title'],       
                    'slug' => $data['slug'],
                    'author_name'=> $data['author_name'], 
                    'short_description' => $data['short_description'],
                    'content' => $data['content'],
                    'category_id' => $data['category_id'],
                    'tags' => $data['tags'],
                    'status' => 1,
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
                    'title' => $data['title'],       
                    'slug' => $data['slug'],
                    'author_name'=> $data['author_name'], 
                    'short_description' => $data['short_description'],
                    'content' => $data['content'],
                    'category_id' => $data['category_id'],
                    'tags' => $data['tags'],
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
}
