<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
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
        $rules = [
            'name'    => 'required|string|max:255',
            'product_type_id' => 'required|exists:product_types,id',
            'category_id' => 'required|exists:categories,id',
        ];

        if ($this->route()->getName()=='admin.topics.store') {
            // Ensure name is unique for the same product type
            $rules['name'] .= '|unique:topics,name,NULL,id,product_type_id,' . $this->product_type_id. ',category_id,' . $this->category_id;
        } elseif ($this->route()->getName()=='admin.topics.update') {
            $catId = $this->route('id'); // Get category ID from route
            // Ensure name is unique for the same product type, excluding the current category being updated
            $rules['name'] .= '|unique:topics,name,' . $catId . ',id,product_type_id,' . $this->product_type_id.',category_id,' . $this->category_id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'    => 'Topic Name is required',
            'name.unique'      => 'This Topic name already exists for the selected product type and category',
            'product_type_id.required' => 'Product type is required',
            'product_type_id.exists' => 'Selected product type does not exist',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category does not exist',
        ];
    }
}
