<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct() 
    {
    }

    public function index()
    {
         return view('front.pages.login');
    }
    public function forgotPassword()
    {
         return view('front.pages.forgot-password');
    }
}
