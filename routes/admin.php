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
        Route::get('/', 'index');
        Route::get('dashboard', 'index')->name('dashboard');
        Route::get('logout', 'logout')->name('logout');
    });
    // User routes
    Route::prefix('users/')->name('users.')->controller(UsersController::class)->group(function () {
        Route::get('', 'index')->name('listing')->middleware('can:user.view');
        Route::get('add', 'create')->name('create')->middleware('can:user.create');
        Route::get('edit/{id}', 'edit')->name('edit')->middleware('can:user.edit');
        Route::post('store', 'store')->name('store')->middleware('can:user.create');
        Route::post('update/{id}', 'update')->name('update')->middleware('can:user.edit');
        Route::delete('delete', 'destroy')->name('delete')->middleware('can:user.delete');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile/update', 'updateProfile')->name('profile.update');
    });
    // Role routes
    Route::prefix('roles/')->name('roles.')->controller(RoleController::class)->group(function () {
        Route::get('', 'index')->name('listing')->middleware('can:role.view');
        Route::get('add', 'create')->name('add')->middleware('can:role.create');
        Route::get('edit/{id}', 'edit')->name('edit')->middleware('can:role.edit');
        Route::post('store', 'store')->name('store')->middleware('can:role.create');
        Route::post('update/{id}', 'update')->name('update')->middleware('can:role.edit');
        Route::delete('delete', 'destroy')->name('delete')->middleware('can:role.delete');
    });

    // Category routes
    Route::prefix('categories/')->name('categories.')->controller(CategoryController::class)->group(function () {
        Route::get('', 'index')->name('listing')->middleware('can:productCategory.view');
        Route::get('add', 'create')->name('create')->middleware('can:productCategory.create');
        Route::get('edit/{id}', 'edit')->name('edit')->middleware('can:productCategory.edit');
        Route::post('store', 'store')->name('store')->middleware('can:productCategory.create');
        Route::post('update/{id}', 'update')->name('update')->middleware('can:productCategory.edit');
        Route::delete('delete', 'destroy')->name('delete')->middleware('can:productCategory.delete');
        Route::post('filter_by_product_type/{productTypeId}', 'getCategoriesByProductType')->name('filter_by_product_type');
    });
    //blog categories
    Route::prefix('blogcategories/')->name('blogcategories.')->controller(BlogCategoryController::class)->group(function () {
        Route::get('', 'index')->name('listing')->middleware('can:blogCategory.view');
        Route::get('add', 'create')->name('create')->middleware('can:blogCategory.create');
        Route::get('edit/{id}', 'edit')->name('edit')->middleware('can:blogCategory.edit');
        Route::post('store', 'store')->name('store')->middleware('can:blogCategory.create');
        Route::post('update/{id}', 'update')->name('update')->middleware('can:blogCategory.edit');
        Route::delete('delete', 'destroy')->name('delete')->middleware('can:blogCategory.delete');
        Route::post('filter_by_product_type/{productTypeId}', 'getCategoriesByProductType')->name('filter_by_product_type');
    });
    // Topic routes
    Route::prefix('topics/')->name('topics.')->controller(TopicController::class)->group(function () {
        Route::get('', 'index')->name('listing')->middleware('can:productTopic.view');
        Route::get('add', 'create')->name('create')->middleware('can:productTopic.create');
        Route::get('edit/{id}', 'edit')->name('edit')->middleware('can:productTopic.edit');
        Route::post('store', 'store')->name('store')->middleware('can:productTopic.create');
        Route::post('update/{id}', 'update')->name('update')->middleware('can:productTopic.edit');
        Route::delete('delete', 'destroy')->name('delete')->middleware('can:productTopic.delete');
        Route::post('filter_by_category/{categoryId}', 'getTopicsByCategory')->name('filter_by_category');
    });

    // product routes
    Route::prefix('products/')->name('products.')->controller(ProductController::class)->group(function () {
        Route::get('', 'index')->name('listing')->middleware('can:product.view');
        Route::get('add', 'create')->name('create')->middleware('can:product.create');
        Route::get('edit/{id}', 'edit')->name('edit')->middleware('can:product.edit');
        Route::post('store', 'store')->name('store')->middleware('can:product.create');
        Route::post('update/{id}', 'update')->name('update')->middleware('can:product.edit');
        Route::delete('delete', 'destroy')->name('delete')->middleware('can:product.delete');

        Route::get('types', 'productType')->name('types.listing')->middleware('can:productType.view');
        Route::get('types/add', 'createProductType')->name('types.create')->middleware('can:productType.create');
        Route::get('types/edit/{id}', 'editProductType')->name('types.edit')->middleware('can:productType.edit');
        Route::post('types/store', 'storeProductType')->name('types.store')->middleware('can:productType.create');
        Route::post('types/update/{id}', 'updateProductType')->name('types.update')->middleware('can:productType.edit');
        Route::delete('types/delete', 'destroyProductType')->name('types.delete')->middleware('can:productType.delete');        
    });

    Route::prefix('blog/')->name('blog.')->controller(BlogController::class)->group(function () {
        Route::get('', 'index')->name('listing')->middleware('can:blog.view');
        Route::get('add', 'create')->name('create')->middleware('can:blog.create');
        Route::get('edit/{id}', 'edit')->name('edit')->middleware('can:blog.edit');
        Route::post('store', 'store')->name('store')->middleware('can:blog.create');
        Route::post('update/{id}', 'update')->name('update')->middleware('can:blog.edit');
        Route::delete('delete', 'destroy')->name('delete')->middleware('can:blog.delete');
    });

    Route::prefix('setting/')->name('setting.')->controller(SettingController::class)->group(function () {
        Route::get('', 'index')->name('index')->middleware('can:setting.view');
        Route::post('website-setting', 'storeDefaultSetting')->name('store.default')->middleware('can:setting.view');
        Route::post('smtp-setting', 'storeSmtpSetting')->name('store.smtp')->middleware('can:setting.view');
        Route::post('send-test-email', 'sendTestEmail')->name('send_test_email')->middleware('can:setting.view');
    });
});

 