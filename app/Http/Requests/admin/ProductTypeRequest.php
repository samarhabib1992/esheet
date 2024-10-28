<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request
    }

    public function rules()
    {
        $rules = [
            'name'    => 'required|string|max:255'
        ];
        if ($this->route()->getName()=='admin.products.types.store') {
            $rules['name'] .= '|unique:product_types,name'; 
        } elseif ($this->route()->getName()=='admin.products.types.update') {
            $id = $this->route('id'); // Get  ID from route
            $rules['name'] .= '|unique:product_types,name,' . $id;        
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'    => 'Product Type is required',
            'name.unique'           => 'This Product Type is already taken',
        ];
    }
}
