<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\BlogService;
use App\Http\Requests\admin\BlogRequest;

class BlogController extends Controller
{
    protected $blogService;
    public function __construct(BlogService $blogService) 
    {
        $this->blogService = $blogService;
    }

    public function index()
    {
        $result = $this->blogService->getAll();
        return view('admin.pages.blog.index',compact('result'));
    }

    public function create()
    {
        return view('admin.pages.blog.create');
    }

    public function store(BlogRequest $request)
    {
        $validatedData = $request->all();
        $response = $this->blogService->store($validatedData);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Blog Post created successfully',
               'redirect_url' => route('admin.blog.listing')
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
            $row = $this->blogService->edit($id);
            if(empty($row)){
                return redirect(route('admin.blog.listing'));
            }  // Redirect to listing page if record not found  //
        }else{
            redirect(route('admin.blog.listing'));
        }
        return view('admin.pages.blog.create', compact('row'));
    }
    public function update(BlogRequest $request, $id)
    {
        $validatedData = $request->all();
        $response = $this->blogService->update($validatedData, $id);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Blog Post updated successfully',
               'redirect_url' => route('admin.blog.listing')
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }
    public function destroy(Request $request){
        $id = $request->only('id');
        $response = $this->blogService->delete($id);
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
