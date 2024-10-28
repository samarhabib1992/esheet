<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\TemplateMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\admin\LoginRequest;
use App\Http\Requests\admin\ForgotPasswordRequest;

class LoginController extends Controller
{

    public function __construct()
    {
    }
    
    /**
     * Show the login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // Retrieve cookie value
         $cookieValue = Cookie::get('esheetCredentials');
        $decryptedValue = $cookieValue ? Crypt::decrypt($cookieValue) : '';
        // Assuming the cookie is JSON-encoded, decode it
        $credentials = $decryptedValue ? json_decode($decryptedValue, true) : [];
        return view('admin.pages.auth.login', compact('credentials'));
    }

    /**
     * Handle an incoming login request.
     *
     * @param  \App\Http\Requests\admin\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request) 
    {  
        $authenticated = $request->validated();
        if($authenticated) {
            $request->authenticate();
            $request->session()->regenerate();
            return response()->json([
                'message' => 'Login Successful',
                'redirect_url' => route('admin.dashboard'),
            ], 200);
        }
        Auth::logout();
        return response()->json([
            'message' => 'Please check your credentials and try again.'
        ], 429);
    }

    /**
     * Show the forgot password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showForgetPasswordForm()
    {
        return view('admin.pages.auth.forgot-password');
    }
 
    public function submitForgetPasswordForm(ForgotPasswordRequest $request)
    {

        // Find the user by email
        $user = User::where('email', $request->email)->where('status', '1')->first();

        if (!$user) {
            return response()->json([
                'message' => 'Please enter a valid email address.',
            ], 422);
        }
        
        // Generate password reset token
        $token = Str::random(60);
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => carbon::now(),
        ]);
        $resetLink = url(route('admin.reset-password.form', ['token' => $token, 'email' => $user->email]));
        $userName = $user->first_name." ".$user->last_name;
        $mailData = [
            'to_email' => $request['email'],
            'from_email' => 'shahzad.aziz1@gmail.com' ?? null,
            'from_name' => 'Esheet' ?? null,
            'subject' => "Password Reset Request",
            'content' => "Hi $userName,<br><br>A password reset has been requested for your account. Please click the link below to reset your password:<br><br>
            <a href=\"{$resetLink}\">Reset Password</a><br><br>
            If you did not request a password reset, please ignore this email.",
            'cc' =>  '',
            'bcc' => '',
            'reply_to' => 'no-reply@esheet.com',
        ];
         // Send the email
         Mail::to($mailData['to_email'])->send(new TemplateMail($mailData));

         return response()->json([
            'message' => 'Please check your email for further instructions.',
            'redirect_url' => route('admin.login'),
        ], 200);
    }

    public function showResetPasswordForm($token,$email){
        $message = '';
        $passwordReset = DB::table('password_reset_tokens')->where(['email' => $email, 'token' => $token])->first();
        if (!$passwordReset){
            $message = 'The provided link is invalid or has expired.';
            return view('admin.pages.auth.reset-password', compact('message'));
        }
        return view('admin.pages.auth.reset-password', compact('message','token', 'email'));
    }
    public function submitResetPasswordForm(Request $request) {
        // Validate the request
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);

        // Check for the token in the password_resets table
        $passwordReset = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$passwordReset || !hash_equals($passwordReset->token, $request->token)) {
            return response()->json([
                'message' => 'Password reset token is invalid. Please try again',
            ], 422);
        }

        // Update the user's password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Optionally delete the token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $userName = $user->first_name." ".$user->last_name;
        $mailData = [
            'to_email' => $request['email'],
            'from_email' => 'shahzad.aziz1@gmail.com' ?? null,
            'from_name' => 'Esheet' ?? null,
            'subject' => "Password Reset Successfully!",
            'content' => "Hi $userName,<br><br> Your password has been reset successfully. You can now log in with your new password.",
            'cc' =>  '',
            'bcc' => '',
            'reply_to' => 'no-reply@esheet.com',
        ];
         // Send the email
         Mail::to($mailData['to_email'])->send(new TemplateMail($mailData));
        return response()->json([
            'message' => 'Password reset successfully',
            'redirect_url' => route('admin.login'),
         ], 200);
     }
}
