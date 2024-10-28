<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct() 
    {
    }

    public function index()
    {
         return view('front.pages.blog');
    }

    public function singlePost(){
        return view('front.pages.single-post');
    }
}
