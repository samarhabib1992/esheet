<?php

namespace App\Http\Requests\admin;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        // Allow all users to make this request
        return true;
    }

    public function rules()
    {
        $rules = [
            'role_id' => [
                'required',
                'exists:roles,id',
                function ($attribute, $value, $fail) {
                    // Check if the role name is 'Super Admin'
                    $role = Role::find($value);
                    if ($role && $role->name === 'Super Admin') {
                        $fail('Please select a valid role.');
                    }
                },
            ],
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'mobile_number' => 'required|numeric',
            'email'         => 'required|email|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ];

        // Check if the request is for creating a user
        if ($this->route()->getName()=='admin.users.store') {
            $rules['password'] = 'required|min:8|confirmed'; // Password required on create
            $rules['email'] .= '|unique:users,email'; // Ensure email is unique on create
        } 
        
        // Check if the request is for updating a user
        elseif ($this->route()->getName()=='admin.users.update') {
            $rules['password'] = 'nullable|min:8|confirmed'; // Password optional on update
            $userId = $this->route('id'); // Retrieve the user ID from the route
            $rules['email'] .= '|unique:users,email,' . $userId; // Exclude current user's email from unique validation
        } 
        
        // Check if the request is for updating a user's profile
        elseif ($this->route()->getName()=='admin.users.update.profile') {
            $rules['password'] = 'nullable|min:8|confirmed'; // Password optional on profile update
            $userId = Auth::id(); // Get the authenticated user ID
            $rules['email'] .= '|unique:users,email,' . $userId; // Exclude current user's email from unique validation
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'first_name.required'    => 'First name is required',
            'last_name.required'     => 'Last name is required',
            'email.required'         => 'Email is required',
            'email.unique'           => 'This email is already taken',
            'password.required'      => 'Password is required',
            'password.confirmed'     => 'Passwords do not match',
            'mobile_number.required' => 'Mobile number is required',
        ];
    }
}
