<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\RoleRequest;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        // Get all roles with their permissions
        $result = Role::where('name', '!=', 'Super Admin')->get();
        return view('admin.pages.roles.index', compact('result'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.pages.roles.create', compact('permissions'));
    }
    public function edit($id)
    {
        $permissions = Permission::all();
        $row = Role::where('id', $id)->where('name', '!=', 'Super Admin')->first();
        if(empty($row)){
            return redirect()->route('admin.roles.listing')->with('error', 'Role not found');
        }
        return view('admin.pages.roles.create',compact('permissions','row'));
    }
    public function store(RoleRequest $request)
    {
        // Create a new role
        $role = Role::create([
            'name' => $request->name,
        ]);

        // Attach the selected permissions
        $role->permissions()->attach($request->permissions);

        return response()->json([
            'message' => 'Role created successfully',
            'redirect_url' => route('admin.roles.listing')
        ], 200);
    }

    public function update(RoleRequest $request, $id)
    {
        // Find the existing role
        $role = Role::where('name', '!=', 'Super Admin')->where('id', $id)->first();
        if($role){
            // Update the role name
            $role->name = $request->name;
            $role->save();

            // Sync the permissions
            $role->permissions()->sync($request->permissions);

            return response()->json([
                'message' => 'Role updated successfully',
                'redirect_url' => route('admin.roles.listing')
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Please select valid role to update",
        ], 422);
    }

    public function destroy(Request $request)
    {
        // Validate the incoming request for required parameters
        $request->validate([
            'id' => 'required|exists:roles,id', // Ensure 'id' is provided and exists in the roles table
        ]);

        // Attempt to find the role, excluding 'Super Admin'
        $role = Role::where('name', '!=', 'Super Admin')->where('id', $request->id)->first();
        // Check if the role exists
        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found or you are trying to delete the Super Admin role.',
            ], 404);
        }

        // Check if the role is linked with any users
        if ($role->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'This role is linked with many users and cannot be deleted.',
            ], 422);
        }

       
        // Detach permissions from the role
        $role->permissions()->detach();
        // Proceed to delete the role
        $role->delete();
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully!',
        ], 200);
        
    }

}
