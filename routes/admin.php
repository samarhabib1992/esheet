<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\TopicController; 
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogCategoryController;

Route::middleware(['admin_guest'])->controller(LoginController::class)->group(function (){
    Route::get('login', 'index')->name('login');
    Route::post('login', 'login')->name('verify.login');
    Route::get('forget-password', 'showForgetPasswordForm')->name('forgot-password.form');
    Route::post('forgot-password', 'submitForgetPasswordForm')->name('forgot-password.sendemail');
    Route::get('reset-password/{token}/{email}', 'showResetPasswordForm')->name('reset-password.form');
    Route::post('reset-password', 'submitResetPasswordForm')->name('reset-password.change');
});

// Dashboard route (requires authentication)
Route::middleware(['isAdmin'])->group(function () {

    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('dashboard');
        Route::get('logout', 'logout')->name('logout');
    });
    // User routes
    Route::prefix('users/')->name('users.')->controller(UsersController::class)->group(function () {
        Route::get('', 'index')->name('listing');
        Route::get('add', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store', 'store')->name('store');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete', 'destroy')->name('delete');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile/update', 'updateProfile')->name('profile.update');
    });
    // Role routes
    Route::prefix('roles/')->name('roles.')->controller(RoleController::class)->group(function () {
        Route::get('', 'index')->name('listing');
        Route::get('add', 'create')->name('add');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store', 'store')->name('store');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete', 'destroy')->name('delete');
    });

    // Category routes
    Route::prefix('categories/')->name('categories.')->controller(CategoryController::class)->group(function () {
        Route::get('', 'index')->name('listing');
        Route::get('add', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store', 'store')->name('store');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete', 'destroy')->name('delete');
        Route::post('filter_by_product_type/{productTypeId}', 'getCategoriesByProductType')->name('filter_by_product_type');
    });
    //blog categories
    Route::prefix('blogcategories/')->name('blogcategories.')->controller(BlogCategoryController::class)->group(function () {
        Route::get('', 'index')->name('listing');
        Route::get('add', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store', 'store')->name('store');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete', 'destroy')->name('delete');
        Route::post('filter_by_product_type/{productTypeId}', 'getCategoriesByProductType')->name('filter_by_product_type');
    });
    // Topic routes
    Route::prefix('topics/')->name('topics.')->controller(TopicController::class)->group(function () {
        Route::get('', 'index')->name('listing');
        Route::get('add', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store', 'store')->name('store');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete', 'destroy')->name('delete');
        Route::post('filter_by_category/{categoryId}', 'getTopicsByCategory')->name('filter_by_category');
    });

    // product routes
    Route::prefix('products/')->name('products.')->controller(ProductController::class)->group(function () {
        Route::get('', 'index')->name('listing');
        Route::get('add', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store', 'store')->name('store');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete', 'destroy')->name('delete');

        Route::get('types', 'productType')->name('types.listing');
        Route::get('types/add', 'createProductType')->name('types.create');
        Route::get('types/edit/{id}', 'editProductType')->name('types.edit');
        Route::post('types/store', 'storeProductType')->name('types.store');
        Route::post('types/update/{id}', 'updateProductType')->name('types.update');
        Route::delete('types/delete', 'destroyProductType')->name('types.delete');        
    });

    Route::prefix('blog/')->name('blog.')->controller(BlogController::class)->group(function () {
        Route::get('', 'index')->name('listing');
        Route::get('add', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store', 'store')->name('store');
        Route::post('update/{id}', 'update')->name('update');
        Route::delete('delete', 'destroy')->name('delete');
    });

    Route::prefix('setting/')->name('setting.')->controller(SettingController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('website-setting', 'storeDefaultSetting')->name('store.default');
        Route::post('smtp-setting', 'storeSmtpSetting')->name('store.smtp');
        Route::post('send-test-email', 'sendTestEmail')->name('send_test_email');
    });
});

 