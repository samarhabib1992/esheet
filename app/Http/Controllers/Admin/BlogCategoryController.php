<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\BlogCategoryService;
use App\Http\Requests\admin\BlogCategoryRequest;

class BlogCategoryController extends Controller
{
    protected $categoryService;
    public function __construct(BlogCategoryService $categoryService) 
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $result = $this->categoryService->listing();
        return view('admin.pages.blog-categories.index',compact('result'));
    }

    public function create()
    {
        return view('admin.pages.blog-categories.create');
    }

    public function store(BlogCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->categoryService->store($validatedData);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Category created successfully',
               'redirect_url' => route('admin.blogcategories.listing')
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
                return redirect(route('admin.blogcategories.listing'));
            }  // Redirect to listing page if record not found  //
        }else{
            redirect(route('admin.blogcategories.listing'));
        }
        return view('admin.pages.blog-categories.create', compact('row'));
    }
    public function update(BlogCategoryRequest $request, $id)
    {
        $validatedData = $request->validated();
        $response = $this->categoryService->update($validatedData, $id);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Category updated successfully',
               'redirect_url' => route('admin.blogcategories.listing')
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
}
