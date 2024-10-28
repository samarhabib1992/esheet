<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User; // Import your User model

class ForgotPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ensure this is authorized
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    // Check if the user exists and is 
                    $user = User::where(['email' => $value, 'status' => 1])->first();
                    if (!$user) {
                        $fail('Please enter a valid email address.');
                    } 
                },
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->checkThrottle($validator);
        });
    }

    protected function checkThrottle($validator)
    {
        $key = $this->throttleKey();
        $maxAttempts = 3; // Maximum 3 attempts
        $decayMinutes = 10; // Block for 10 minutes

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            RateLimiter::hit($key, $decayMinutes * 60); // Register another hit to the throttle
            throw ValidationException::withMessages([
                'email' => 'Too many password reset attempts. Please try again later.',
            ]);
        }

        RateLimiter::hit($key); // Increment the throttle count
    }

    protected function throttleKey()
    {
        // Use IP address and email for the throttle key
        return $this->ip() . '|' . $this->input('email');
    }

      /**
     * Get the validation error messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }
}
