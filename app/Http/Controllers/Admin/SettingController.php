<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\SettingService;
use App\Services\Admin\CustomEmailService;
use App\Http\Requests\admin\SettingRequest;
use App\Http\Requests\admin\SendTestEmailRequest;
class SettingController extends Controller
{
    protected $settingService, $emailService;
    public function __construct(SettingService $settingService, CustomEmailService $emailService) 
    {
        $this->settingService = $settingService;
        $this->emailService = $emailService;

    }
    public function index()
    {
        $row = $this->settingService->show();
        return view('admin.pages.setting.index',compact('row'));
    }

    public function storeDefaultSetting(SettingRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->settingService->storeDefaultSetting($validatedData);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Settings saved successfully',
               'redirect_url' => route('admin.setting.index')
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }

    public function storeSmtpSetting(SettingRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->settingService->storeSmtpSetting($validatedData);
        if ($response['statusCode'] == 200) {
            return response()->json([
               'message' => 'Smtp Setting saved successfully',
               'redirect_url' => route('admin.setting.index')
            ], 200);
        } else {    
            return response()->json([
                'message' => $response['message'],
            ], 422);
        }
    }
    public function sendTestEmail(SendTestEmailRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $emailData = [
                'subject' => 'Test Email',
                'content' => 'This is a test email sent from the e-Sheet application.',
                'attachments' => [],
            ];
            // Call the EmailService to send the test email
           $response = $this->emailService->sendTestEmail($validatedData['test_email'],$emailData);
           if($response['status'] == 'success'){
            // Return success response
                return response()->json([
                    'status' => 'success',
                    'message' => 'Test email sent successfully!',
                    'redirect_url' => route('admin.setting.index')
                ], 200);   
           }
           // Return error response
           return response()->json([
                'status' => 'error',
                'error' => 'Failed to send email. Please try again later.',
            ], 422);
            
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 'error',
                'error' => 'Failed to send email. Please try again later.',
            ], 422);
        }
    }    
}
