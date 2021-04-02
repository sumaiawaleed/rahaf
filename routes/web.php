<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('clear-compiled');
    //$exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
    Auth::routes();

    Route::get('/', 'HomeController@index');
    Route::get(env('DASH_URL') . '/login', 'Auth\LoginController@showAdminLoginForm');
    Route::post(env('DASH_URL') . '/loginProcess', 'Auth\LoginController@adminLogin')->name(env('DASH_URL') . '/loginProcess');


    Route::post('postLogin', 'Auth\LoginController@postLogin')->name('postLogin');
    Route::any('change_currency', 'HomeController@change_currency')->name('change_currency');


    Route::get('user/profile', 'Customers\CustomerController@profile')->name('user.profile');
    Route::post('update_profile', 'Customers\CustomerController@update')->name('update_profile');
    Route::post('update_location', 'Customers\CustomerController@update_location')->name('update_location');
    Route::get('change_password', 'Customers\CustomerController@change_password')->name('user/change_password');
    Route::post('update_password', 'Customers\CustomerController@update_password')->name('user/update_password');
    Route::get('user/orders', 'Customers\OrderController@index')->name('user/orders');
    Route::get('user/orders/show', 'Customers\OrderController@show')->name('user/orders.show');

    Route::post('user/rate', 'Customers\RatetController@rate')->name('user/rate');
    Route::post('user/delete_rate', 'Customers\RatetController@delete_rate')->name('user/delete_rate');

    Route::get('user/favorites', 'Customers\WishlistController@index')->name('user/favorites');
    Route::post('remove_wishlist', 'Customers\WishlistController@remove')->name('remove_wishlist');
    Route::post('add_wishlist', 'Customers\WishlistController@add')->name('add_wishlist');
    Route::post('wishlist', 'Customers\WishlistController@wishlist')->name('wishlist');

    Route::resource('cart', 'CartController')->except(['create', 'edit', 'show']);

    Route::any('add_to_cart', 'CartController@add_to_cart')->name('add_to_cart');
    Route::any('edit_cart', 'CartController@edit_cart')->name('edit_cart');
    Route::any('view_cart', 'CartController@view_cart')->name('view_cart');
    Route::any('delete_cart', 'CartController@delete_cart')->name('delete_cart');
    Route::any('view_cart_model', 'CartController@view_cart')->name('view_cart_model');
    Route::get('checkout', 'CartController@checkout')->name('checkout');
    Route::post('checkout', 'CartController@checkout_process')->name('checkout');


    Route::get('products', 'ProductController@index')->name('products');
    Route::get('offers', 'ProductController@offers')->name('offers');
    Route::get('latest', 'ProductController@latest')->name('latest');
    Route::get('categories', 'CategoryController@index')->name('categories');
    Route::get('product/show/{id}', 'ProductController@show')->name('product.show');

    Route::any('categories/get_sub', 'Dashboard\CategoryController@get_sub')->name('categories/get_sub');
    Route::any('sub_categories/get_sub', 'Dashboard\SubCategoryController@get_sub')->name('sub_categories/get_sub');


    Route::get('about', 'PageController@about')->name('about');
    Route::get('polices', 'PageController@polices')->name('polices');
    Route::get('terms', 'PageController@terms')->name('terms');
    Route::get('contact-us', 'ContactUsController@index')->name('contact-us');
    Route::post('send_message', 'ContactUsController@send')->name('send_message');

});


//->middleware(['auth:__ac'])


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');


Route::get('apiTest/all', function () {
    return view('apis.all');
});

Route::get('apiTest/general', function () {
    return view('apis.index');
})->name("apiTest/general");

Route::get('apiTest/auth', function () {
    return view('apis.auth');
})->name('apiTest/auth');


Route::get('apiTest/users', function () {
    return view('apis.users');
})->name('apiTest/users');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
