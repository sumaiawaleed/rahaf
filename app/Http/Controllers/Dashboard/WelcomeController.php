<?php

namespace App\Http\Controllers\Dashboard;

use App\Ad;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{


    public function index(){
       $data['title'] = __('site.home');
       $data['customers'] = Customer::count();
       $data['ads'] = Product::count();
       $data['orders'] = Order::count();
       return view('dashboard.index',compact('data'));


    }
}
