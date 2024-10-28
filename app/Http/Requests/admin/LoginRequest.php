<?php

namespace App\Http\Requests\admin;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest 
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable|boolean',
        ];
    }

     /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $email = $this->input('email');
        $password = $this->input('password');
        $remember = $this->input('remember');
        $credentials = [
            'email' => $email, 
            'password' => $password, 
            'status' => '1'
        ];
        // Attempt to authenticate the user
        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->throttleKey());
            $response = response()->json([
                'message'  => 'Please check your credentials and try again.',
            ],429);
            throw new HttpResponseException($response);
        }

        //new for cookies start
        if ($remember) {
            // Encrypt the credentials and store it in the cookie
            $encryptCredentials = encrypt(json_encode(['email' => $email, 'password' => $password , 'remember' => $remember]));
            // Create a cookie with a 7-day expiration time (10,080 minutes)
            $cookie = cookie('esheetCredentials', $encryptCredentials, 10080);
            // Send the cookie in the response
            app('cookie')->queue($cookie);
        } else {
            // Delete the credentials cookie if remember is off
            $cookie = cookie()->forget('esheetCredentials');

            // Send the cookie deletion in the response
            app('cookie')->queue($cookie);
        }
        //new for cookies end
        RateLimiter::clear($this->throttleKey());
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => $validator->errors(),
        ], 429);
        throw new HttpResponseException($response);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());
        
        $response = response()->json([
            'message' => __('Too many login attempts. Please try again in :seconds seconds.', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ], 429);
        log::info('Too many login attempts. Please try again in :seconds seconds.', ['seconds' => $seconds]);
        throw new HttpResponseException($response);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
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
            'password.required' => 'Password is required.',
            'remember.boolean' => 'Remember me must be a valid value.',
        ];
    }
}
