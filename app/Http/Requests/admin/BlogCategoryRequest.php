<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request
    }

    public function rules()
    {
        $rules = [
            'name'    => 'required|string|max:255'      ];

        if ($this->route()->getName()=='admin.blogcategories.store') {
            // Ensure name is unique for the same product type
            $rules['name'] .= '|unique:categories,name,NULL,id';
        } elseif ($this->route()->getName()=='admin.blogcategories.update') {
            $catId = $this->route('id'); // Get category ID from route
            // Ensure name is unique for the same product type, excluding the current category being updated
            $rules['name'] .= '|unique:categories,name,' . $catId . ',id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'    => 'Category name is required',
            'name.unique'      => 'This category name already exists for the selected product type',
            'product_type_id.required' => 'Product type is required',
            'product_type_id.exists' => 'Selected product type does not exist',
        ];
    }
}