<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Return true if the user is authorized to perform the action.
        return true;  // Adjust this based on your application's authorization logic.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'short_description' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:blog_categories,id', // Validates the category_id
            'tags' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image file
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'The blog title is required.',
            'author_name.required' => 'The author name is required.',
            'short_description.required' => 'A short description is required.',
            'content.required' => 'Blog content is required.',
            'category_id.required' => 'Please select a valid category.',
            'category_id.exists' => 'The selected category does not exist.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be of type jpeg, png, jpg, gif, or svg.',
            'image.max' => 'The image size must not exceed 2MB.',
            'tags' => 'The tags field must be an array.',
        ];
    }
}
