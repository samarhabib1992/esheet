<?php

namespace App\Services\Admin;

use Exception;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UsersService extends BaseService implements UserRepositoryInterface
{
    protected $userRepository;
    /**
     * Initializes the UserRepositoryInterface with the required dependencies.
     *
     */
    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->setRepository($userRepository);
    }

    public function getAll()
    {
        $columns  = ['id', 'first_name', 'last_name', 'email', 'mobile_number', 'profile_picture', 'user_type', 'status', 'role_id', 'created_at'];
        $conditions = [
            'user_type' => 'user',
        ];
        $relations = [
            'role' => function ($query) {
                $query->select(['id', 'name']);
            }
        ];
        $orderBy = ['created_at' => 'DESC'];
        $perPage = 15;
        return $this->repository->findRecordsByPagination($conditions, $columns,$relations,$orderBy,$perPage);
    }
    public function edit($id=null){
        return $this->repository->show($id);
    }
    public function store(array $data = [])
    {
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],  
            'mobile_number' => $data['mobile_number'],
            'user_type' => 'user',
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'status' => '1',
        ];
         // Handle image upload if it exists
        if (!empty($data['image'])) {
            $image = $data['image'];
            $imageName = time() . '_' . $image->getClientOriginalName(); // Create a unique name
            $path = $image->storeAs('users', $imageName, 'public'); 
            $userData['profile_picture'] = $path; // Save the path to 'image' column
        }

       $user = $this->repository->create($userData);
       $user->assignRole(Role::where('id', $data['role_id'])->pluck('name')->first());
       return $user;
    }

    public function update(array $data = [], $id = null) 
    {
        // Trim and validate password
        $password = isset($data['password']) ? trim($data['password']) : null;
        
        // Prepare data to be updated
        $updateData = [
            'role_id' => $data['role_id'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'mobile_number' => $data['mobile_number'],
        ];
        
        // Update password if it's not empty
        if (!empty($password)) {
            $updateData['password'] = Hash::make($password);
        }
         // Handle image upload if it exists
         if (!empty($data['image'])) {
            $image = $data['image'];
            $imageName = time() . '_' . $image->getClientOriginalName(); // Create a unique name
            $path = $image->storeAs('users', $imageName, 'public'); 
            $userData['profile_picture'] = $path; // Save the path to 'image' column
        }
        // Perform the update using the repository
        $user = $this->repository->update($updateData, $id);
        $user->assignRole(Role::where('id', $data['role_id'])->pluck('name')->first());
        return $user;
    }
    public function delete(array $data=[]){
        DB::beginTransaction();
        try {
            $columns = ['*'];
            $relations = [];
            $conditions = [
                'id' => $data['id'],
                'user_type' => 'user',
            ];
            $user = $this->repository->findRecord($columns,$relations,$conditions);
            if($user) {
                $user->delete();
            }
             // Commit transaction
             DB::commit();
            // Return error response if exception occurs
            return [
                'statusCode' => 200,
                'success' => true,
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
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
