<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct() 
    {
    }

    public function index()
    {
         return view('front.pages.faq');
    }
}
