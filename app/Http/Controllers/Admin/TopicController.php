<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\TopicService;
use App\Http\Requests\admin\TopicRequest;

class TopicController extends Controller
{
    protected $topicService;

    public function __construct(TopicService $topicService)
    {
        $this->topicService = $topicService;
    }

    // List topics
    public function index()
    {
        $result = $this->topicService->getAll();
        return view('admin.pages.topics.index', compact('result'));
    }

    // Show form for creating a new topic
    public function create()
    {
        return view('admin.pages.topics.create');
    }

    // Store a newly created topic
    public function store(TopicRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->topicService->store($validatedData);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Topic created successfully',
               'redirect_url' => route('admin.topics.listing')
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }

    // Show the form for editing the specified topic
    public function edit($id)
    {
        if(!empty($id)){
            $row = $this->topicService->edit($id);
            if(empty($row)){
                return redirect(route('admin.pages.topics.listing'));
            }  // Redirect to listing page if record not found  //
        }else{
            redirect(route('admin.pages.topics.listing'));
        }
        return view('admin.pages.topics.create', compact('row'));
    }

    // Update the specified topic
    public function update(TopicRequest $request, $id)
    {
         $validatedData = $request->validated();
        $response = $this->topicService->update($validatedData, $id);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Topic updated successfully',
               'redirect_url' => route('admin.topics.listing')
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }

    // Delete the specified topic
    public function destroy(Request $request){
        $id = $request->only('id');
        $response = $this->topicService->delete($id);
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

    public function getTopicsByCategory($category_id){
        if(empty($category_id)){
            return response()->json([
                'message' => 'Please provide category first',
            ], 422);
        } 
        $response = $this->topicService->getTopicsByCategory($category_id);
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
