<?php

namespace App\Services\Admin;

use Exception;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService extends BaseService implements ProductRepositoryInterface
{
    protected $productRepository;
    /**
     * Initializes the ProductRepositoryInterface with the required dependencies.
     *
     */
    public function __construct(ProductRepositoryInterface $productRepository) 
    {
        $this->setRepository($productRepository);
    }

    public function getAll()
    {
        $columns  = ['id', 'name','product_type_id','category_id','topic_id','price','description'];
        $conditions = [
        ];
        $relations = [
            'productType' => function($query) {
                $query->select(['id', 'name']);
            },
            'category' => function($query) {
                $query->select(['id', 'name']);
            },
            'topic' => function($query) {
                $query->select(['id', 'name']);
            },
        ];
        $orderBy = ['created_at' => 'DESC'];
        $perPage = 15;
        return $this->repository->findRecordsByPagination($conditions, $columns,$relations,$orderBy,$perPage);
    }
    
    public function edit($id=null){
        if(!empty($id)){
           $columns = ['*'];
           $relations = [
            'attachments' => function($query) {
                $query->select(['id', 'attachment_name', 'attachment_path', 'attachment_type', 'attachment_size', 'attachable_type', 'attachable_id']);
            }
           ];
            $row = $this->repository->show($id,$columns,$relations);
            if(!empty($row)){
                return $row;
            }
        }
        return [];
    }
    public function store(array $data = [])
    {
        $attachments = [];
        if(!empty($data['images'])) {
            foreach ($data['images'] as $file) {
                $attachments[] = [
                    'attachment_name' => $file->getClientOriginalName(),
                    'attachment_path' => $file->store('products', 'public'),
                    'attachment_type' => $file->getClientOriginalExtension(),
                    'attachment_size' => $this->bytesToHuman($file->getSize()),
                ];
            }
        }
        DB::beginTransaction();
        try {           
            if(!empty($data)){
                
                 // Prepare data to be created
                 $productData = [
                    'name' => $data['name'],
                    'product_type_id' => $data['product_type_id'],
                    'category_id' => $data['category_id'],
                    'topic_id' => $data['topic_id'],
                    'price' => $data['price'], 
                    'description' => $data['description'],
                ];
                $product = $this->repository->create($productData);
                if($product && !empty($product) && !empty($attachments)) {
                    $product->attachments()->createMany($attachments);
                }
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
                 $productData = [
                    'name' => $data['name'],
                    'product_type_id' => $data['product_type_id'],
                    'category_id' => $data['category_id'],
                    'topic_id' => $data['topic_id'],
                    'price' => $data['price'], 
                    'description' => $data['description'],
                ];
                // Perform the update using the repository
                $this->repository->update($productData, $id);
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
            $relations = [
                'attachments' => function($query) {
                    $query->select(['id', 'name']);
                }
            ];
            $conditions = [
                'id' => $id
            ];
            $product = $this->repository->findRecord($columns,$relations,$conditions);
            if($product) {
                // Delete attachments
                $attachments = $product->attachments;
                if($attachments){
                    foreach($attachments as $attachment) {
                        $attachment->delete();
                        // Delete file from storage
                        if(file_exists(public_path('uploads/attachments/'. $attachment->name))) {
                            unlink(public_path('uploads/attachments/'. $attachment->name));
                        }
                    }
                }
                // Delete product itself
                $product->delete();
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

    public static function bytesToHuman($bytes)
    {
        if (empty($bytes))
            return null;

        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
