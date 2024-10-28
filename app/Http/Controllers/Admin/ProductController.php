<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;
use App\Services\Admin\ProductTypeService;
use App\Http\Requests\admin\ProductRequest;
use App\Http\Requests\admin\ProductTypeRequest;

class ProductController extends Controller
{
    protected $productService,$productTypeService;
    public function __construct(ProductService $productService, ProductTypeService $productTypeService) 
    {
        $this->productService = $productService;
        $this->productTypeService = $productTypeService;
    }

    public function index()
    {
        $result = $this->productService->getAll();
        return view('admin.pages.products.index',compact('result'));
    }

    public function create()
    {
        return view('admin.pages.products.create');
    }

    public function store(ProductRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->productService->store($validatedData);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Product created successfully',
               'redirect_url' => route('admin.products.listing')
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
            $row = $this->productService->edit($id);
            if(empty($row)){
                return redirect(route('admin.pages.products.listing'));
            }  // Redirect to listing page if record not found  //
        }else{
            redirect(route('admin.pages.products.listing'));
        }
        return view('admin.pages.products.create', compact('row'));
    }
    public function update(ProductRequest $request, $id)
    {
         $validatedData = $request->validated();
        $response = $this->productService->update($validatedData, $id);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Product updated successfully',
               'redirect_url' => route('admin.products.listing')
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }
    public function destroy(Request $request){
        $id = $request->only('id');
        $response = $this->productService->delete($id);
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

    public function productType()
    {
        $result = $this->productTypeService->listing();
        return view('admin.pages.products.types.index',compact('result'));
    }

    public function createProductType()
    {
        return view('admin.pages.products.types.create');
    }
    public function storeProductType(ProductTypeRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->productTypeService->store($validatedData);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Product type created successfully',
               'redirect_url' => route('admin.products.types.listing')
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }
    public function editProductType($id)
    {
        $row = $this->productTypeService->edit($id);
        return view('admin.pages.products.types.create',compact('row'));
    }
    public function updateProductType(ProductTypeRequest $request, $id)
    {
        $validatedData = $request->validated();
        $response = $this->productTypeService->update($validatedData, $id);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Product type updated successfully',
               'redirect_url' => route('admin.products.types.listing')
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }
    public function destroyProductType(Request $request){
        $response = $this->productTypeService->delete($request->only('id'));
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
