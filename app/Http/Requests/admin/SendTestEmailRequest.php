<?php

namespace App\Http\Requests\admin;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class SendTestEmailRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You can set this to check permissions if needed
    }

    public function rules()
    {
        return [
            'test_email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'test_email.required' => 'Test email is required.',
            'test_email.email' => 'Please provide a valid email address.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $settings = Setting::first();

            if (!$settings || 
                empty($settings->smtp_mail_host) || 
                empty($settings->smtp_mail_port) ||
                empty($settings->smtp_mail_username) || 
                empty($settings->smtp_mail_password) ||
                empty($settings->smtp_mail_from_address) || 
                empty($settings->smtp_mail_from_name)) {
                
                $validator->errors()->add('test_email', 'Email settings must be configured correctly before send test email.');
            }
        });
    }
}
