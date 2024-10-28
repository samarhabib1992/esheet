<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\CategoryService;
use App\Http\Requests\admin\CategoryRequest;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService) 
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $result = $this->categoryService->listing();
        return view('admin.pages.categories.index',compact('result'));
    }

    public function create()
    {
        return view('admin.pages.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->categoryService->store($validatedData);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Category created successfully',
               'redirect_url' => route('admin.categories.listing')
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }
    public function edit($id)
    {
        if(!empty($id)){
            $row = $this->categoryService->edit($id);
            if(empty($row)){
                return redirect(route('admin.categories.listing'));
            }  // Redirect to listing page if record not found  //
        }else{
            redirect(route('admin.categories.listing'));
        }
        return view('admin.pages.categories.create', compact('row'));
    }
    public function update(CategoryRequest $request, $id)
    {
        $validatedData = $request->validated();
        $response = $this->categoryService->update($validatedData, $id);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Category updated successfully',
               'redirect_url' => route('admin.categories.listing')
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }
    public function destroy(Request $request){
        $id = $request->only('id');
        $response = $this->categoryService->delete($id);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => $response['message'],
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }
    public function getCategoriesByProductType($product_type_id){
        if(empty($product_type_id)){
            return response()->json([
                'message' => 'Please provide product type first',
            ], 422);
        } 
        $response = $this->categoryService->getCategoriesByProductType($product_type_id);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'data' => $response['data'],
               'message' => $response['message'],
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }
}
