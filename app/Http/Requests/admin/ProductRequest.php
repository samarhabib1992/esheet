<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'product_type_id' => 'required|exists:product_types,id', // Ensures the product type ID exists in the product_types table
            'category_id' => 'required|exists:categories,id', // Ensures the category ID exists in the categories table
            'topic_id' => 'required|exists:topics,id', // Ensures the topic ID exists in the topics table
            'price' => 'required|numeric|gt:1', // Price must be a positive number
            'description' => 'nullable|max:5000',  // Description can be optional (nullable)
            'images' => 'nullable|array|max:5', // Validate that it's an array and limit to 5 images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each image in the array
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a string.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'product_type_id.required' => 'The product type is required.',
            'product_type_id.exists' => 'The selected product type does not exist.',
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category does not exist.',
            'topic_id.required' => 'The topic is required.',
            'topic_id.exists' => 'The selected topic does not exist.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.gt' => 'The price must be greater than 1.',
            'description.max' => 'The description may not be greater than 5000 characters.',
            'images.array' => 'The images field must be an array.',
            'images.max' => 'You may not upload more than 5 images.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Each image must be a JPEG, PNG, JPG, or GIF format.',
            'images.*.max' => 'Each image may not be greater than 2048 kilobytes.',
        ];
    }
}