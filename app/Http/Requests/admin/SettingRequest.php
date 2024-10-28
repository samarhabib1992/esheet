<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request
    }

    public function rules()
    {
        if ($this->routeIs('admin.setting.store.smtp')) {
            return [
                'smtp_mail_host' => 'required|string|max:255',
                'smtp_mail_port' => 'required|integer',
                'smtp_mail_username' => 'required|string|max:255',
                'smtp_mail_password' => 'required|string|max:255',
                'smtp_mail_from_name' => 'required|string|max:255',
                'smtp_mail_from_address' => 'required|email|max:255',
            ];
        }
        else{
            return [
                'company_name' => 'required|string|max:255',
                'mobile_number' => 'nullable|string|max:20',
                'phone_number' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // File validation for logo
            ];
        }
    }

    public function messages()
    {
        return [
            'logo.max' => 'The logo must not be greater than 2MB.',
            'company_name.required' => 'The company name is required.',
            'company_name.max' => 'The company name may not be greater than 255 characters.',
            'mobile_number.max' => 'The mobile number may not be greater than 20 characters.',
            'phone_number.max' => 'The phone number may not be greater than 20 characters.',
            'address.max' => 'The address may not be greater than 255 characters.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'The email address may not be greater than 255 characters.',
            'logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif.',
            'logo.image' => 'The logo must be an image.',
            //smtp
            'smtp_mail_host.required' => 'The SMTP host is required.',
            'smtp_mail_port.required' => 'The SMTP port is required.',
            'smtp_mail_username.required' => 'The SMTP username is required.',
            'smtp_mail_password.required' => 'The SMTP password is required.',
            'smtp_mail_from_name.required' => 'The SMTP from name is required.',
            'smtp_mail_from_address.required' => 'The SMTP from email is required.',
            'smtp_mail_from_address.email' => 'Please enter a valid email address for the SMTP from email.',
        ];
    }
}