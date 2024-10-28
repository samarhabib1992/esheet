<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        // Base rules for role validation
        $rules = [
            'name'        => 'required|string|max:255', // Role name is required and should be a string
            'permissions' => 'required|array|min:1',     // At least one permission is required
            'permissions.*' => 'integer|exists:permissions,id', // Each permission must be a valid integer ID that exists
        ];

        // Check if the request is for creating a role
        if ($this->route()->getName() === 'admin.roles.store') {
            $rules['name'] .= '|unique:roles,name'; // Ensure unique role name on creation
        } 
        
        // Check if the request is for updating a role
        elseif ($this->route()->getName() === 'admin.roles.update') {
            $roleId = $this->route('id'); // Get the role ID from the route
            $rules['name'] .= '|unique:roles,name,' . $roleId; // Unique role name, ignoring the current role being updated
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'role_id.required'     => 'The role is required.',
            'name.required'        => 'The role name is required.',
            'name.string'          => 'The role name must be a string.',
            'name.max'             => 'The role name may not be greater than 255 characters.',
            'name.unique'          => 'This role name is already taken.',
            'permissions.required' => 'At least one permission must be selected.',
            'permissions.array'    => 'Permissions must be an array.',
            'permissions.min'      => 'You must select at least one permission.',
            'permissions.*.integer' => 'Each permission ID must be an integer.',
            'permissions.*.exists' => 'The selected permission ID is invalid.',
        ];
    }
}
