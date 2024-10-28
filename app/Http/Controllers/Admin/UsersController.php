<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Services\Admin\UsersService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\admin\UserRequest;

class UsersController extends Controller
{
    protected $userService;
    public function __construct(UsersService $userService) 
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $result = $this->userService->listing();
        return view('admin.pages.users.index',compact('result'));
    }

    public function profile(){
        $row = $this->userService->edit(Auth::id());
        return view('admin.pages.users.profile',compact('row'));
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        return view('admin.pages.users.create',compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $validateData = $request->validated();
        $this->userService->store($validateData);
        return response()->json([
            'message' => 'User created successfully',
            'redirect_url' => route('admin.users.listing')
        ], 200);
    }
    public function edit($id)
    {
        $row = $this->userService->edit($id);
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        return view('admin.pages.users.create',compact('row','roles'));
    }

    public function update(UserRequest $request, $id)
    {
        $validateData = $request->validated();
        $this->userService->update($validateData, $id);
        return response()->json([
            'message' => 'User updated successfully',
            'redirect_url' => route('admin.users.listing')
        ], 200);
    }
    public function updateProfile(UserRequest $request)
    {
        $validateData = $request->validated();
        $this->userService->update($validateData, Auth::id());
        return response()->json([
            'message' => 'Profile updated successfully',
            'redirect_url' => route('admin.users.profile')
        ], 200);
    }
    public function destroy(Request $request){
        $response = $this->userService->delete($request->only('id'));
        if ($response['statusCode'] == 200) {
            return response()->json([
                'success' => true,
                'message' => $response['message'],
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => $response['message'],
            ], 422);
        }
    }
}
