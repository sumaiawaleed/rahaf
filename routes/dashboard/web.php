<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {
        Route::prefix(env('DASH_URL'))->name(env('DASH_URL') . '.')->middleware(['auth:__rhs_'])->group(function () {

            Route::get('product/data','ProductController@getAutocompleteData')->name('product.data');

            Route::get('home', 'WelcomeController@index')->name('index');
            Route::get('upload_image', 'ProductController@upload_image')->name('upload_image');

            Route::resource('main_categories', 'MainCategoryController')->except(['show']);
            Route::post('main_category/active','MainCategoryController@active')->name('main_category.active');

            Route::resource('categories', 'CategoryController')->except(['show']);
            Route::post('category/active','CategoryController@active')->name('category.active');

            Route::resource('sub_categories', 'SubCategoryController')->except(['show']);

            Route::resource('brands', 'BrandController')->except(['show']);
            Route::get('brand/report','BrandController@report')->name('brand.report');
            Route::post('brand/active','BrandController@active')->name('brand.active');

            Route::resource('pages', 'PageController')->except(['pages']);
            Route::resource('colors', 'ColorController')->except(['show']);
            Route::resource('flavors', 'FlavorController')->except(['show']);

            Route::resource('coupons', 'CouponController')->except(['show']);
            Route::get('dollars', 'DollarController@index')->name('dollars');
            Route::put('dollars', 'DollarController@update')->name('dollars');
            Route::resource('drivers', 'DriverController')->except(['show']);
            Route::get('driver/report','DriverController@report')->name('driver.report');

            Route::resource('products', 'ProductController');
            Route::get('product/reports','ProductController@reports')->name('product.reports');
            Route::resource('orders', 'OrderController');
            Route::resource('orderDetails', 'OrderDetailsController');
            Route::resource('extras', 'ProductExtraController')->except(['show']);


            Route::resource('quantities', 'QuantityController')->except(['show']);
            Route::resource('sub_quantities', 'SubQuantityController')->except(['show']);
            Route::resource('favourites', 'FavouriteController')->except(['show', 'create', 'store', 'edit', 'update']);
            Route::resource('ratings', 'RatingController')->except(['show', 'create', 'store']);


            Route::resource('ads', 'AdvertismentController');
            Route::resource('customers', 'CustomerController');
            Route::get('customer/report','CustomerController@report')->name('customer.report');
            Route::resource('users', 'UserController');
            Route::resource('stores', 'StoreController');
            Route::resource('packages', 'AdPackageController');
            Route::get('requests', 'AdPackageController@user_requests')->name('requests');
            Route::get('home', 'WelcomeController@index')->name('home');
            Route::post('save_excel', 'ProductController@save_excel')->name('save_excel');

        });//end of dashboard routes
    });




