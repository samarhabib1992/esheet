<?php

namespace App\Services\Admin;

use Exception;
use App\Models\Setting;
use GuzzleHttp\Psr7\Request;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingService{
     
    public function show(){
        $row = Setting::first();
        return $row;
    }

    
    public function storeDefaultSetting(array $data = [])
    {
        DB::beginTransaction();
        try {           
            if (!empty($data)) {
                // Prepare data to be created or updated
                $saveData = [
                    'company_name' => $data['company_name'],
                    'mobile_number' => $data['mobile_number'],
                    'phone_number' => $data['phone_number'],
                    'address' => $data['address'],
                    'email' => $data['email'],
                ];

                // Check if a record with ID 1 exists
                $setting = Setting::find(1);
                // Check if a logo file was provided in the data
                if (!empty($data['logo']) && $data['logo'] instanceof UploadedFile) {
                    $logo = $data['logo'];

                    // Generate a unique filename for the logo
                    $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();

                    // Move the file to the 'public/uploads/logo' directory
                    $logoPath = $logo->storeAs('uploads/logo', $logoName, 'public');

                    // Unlink (delete) the old logo if it exists
                    if ($setting && $setting->logo && Storage::disk('public')->exists('uploads/logo/' . $setting->logo)) {
                        Storage::disk('public')->delete('uploads/logo/' .$setting->logo);
                    }

                    // Add new logo path to the data array
                    $saveData['logo'] = $logoName;
                }
                if ($setting) {
                    // If record exists, update it
                    $setting->update($saveData);
                } else {
                    // Otherwise, create a new record with ID 1
                    $setting = Setting::create($saveData);
                }

                DB::commit();

                // Return success response
                return [
                    'statusCode' => 200,
                    'message' => 'Record saved successfully.',
                ];
            }

            // Return failure response if data is empty
            return [
                'statusCode' => 429,
                'message' => 'Please refresh the page and try again.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the exception
            Log::error("Error: " . $e->getMessage());

            // Return error response
            return [
                'statusCode' => 500,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ];
        }
    }
    public function storeSmtpSetting(array $data = [])
    {
        DB::beginTransaction();
        try {
            if (!empty($data)) {
                // Prepare data to be created or updated
                $saveData = [
                    'smtp_mail_host' => $data['smtp_mail_host'],
                    'smtp_mail_port' => $data['smtp_mail_port'],
                    'smtp_mail_username' => $data['smtp_mail_username'],
                    'smtp_mail_password' => $data['smtp_mail_password'],
                    'smtp_mail_from_name' => $data['smtp_mail_from_name'],
                    'smtp_mail_from_address' => $data['smtp_mail_from_address'],
                ];

                // Check if a record with ID 1 exists
                $setting = Setting::find(1);

                if ($setting) {
                    // If record exists, update it
                    $setting->update($saveData);
                } else {
                    // Otherwise, create a new record with ID 1
                    $setting = Setting::create($saveData);
                }
                DB::commit();

                // Return success response
                return [
                    'statusCode' => 200,
                    'message' => 'SMTP settings saved successfully.',
                ];
            }

            // Return failure response if data is empty
            return [
                'statusCode' => 429,
                'message' => 'Please refresh the page and try again.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the exception
            Log::error("Error: " . $e->getMessage());

            // Return error response
            return [
                'statusCode' => 500,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ];
        }
    }

}
