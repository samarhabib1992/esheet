<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function __construct() 
    {
    }

    public function index()
    {
         return view('front.pages.about-us');
    }
    public function privacy()
    {
         return view('front.pages.privacy');
    }
    public function terms()
    {
         return view('front.pages.term');
    }
}
