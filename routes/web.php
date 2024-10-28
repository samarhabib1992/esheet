<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\Front\RegisterController;
use App\Http\Controllers\Front\EbookController;
use App\Http\Controllers\Front\CheatSheetController;
use App\Http\Controllers\Front\ItCertificationController;
use App\Http\Controllers\Front\ExamQuestionsController;
use App\Http\Controllers\Front\FaqController;
use App\Http\Controllers\Front\AboutUsController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\ContactUsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::get('/ebook', [EbookController::class, 'index'])->name('ebooks');
Route::get('/cheat-sheet', [CheatSheetController::class, 'index'])->name('cheat-sheet');
Route::get('/it-certification', [ItCertificationController::class, 'index'])->name('it-certification');
Route::get('/exam-questions', [ExamQuestionsController::class, 'index'])->name('exam-questions');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/post/single', [BlogController::class, 'singlePost'])->name('blog.single-post');
Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact-us');
Route::get('/privacy-policy', [AboutUsController::class, 'privacy'])->name('privacy-policy');
Route::get('/terms-and-conditions', [AboutUsController::class, 'terms'])->name('terms-and-conditions');



