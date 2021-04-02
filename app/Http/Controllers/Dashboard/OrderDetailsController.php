<?php

namespace App\Http\Controllers\Dashboard;

use App\Color;
use App\Customer;
use App\Driver;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetails;
use App\Product;
use App\SubQuantity;
use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:orders-read'])->only('index', 'show');
        $this->middleware(['permission:orders-create'])->only('create', 'store');
        $this->middleware(['permission:orders-update'])->only('edit', 'update');
        $this->middleware(['permission:orders-delete'])->only('destroy');
    }
    public function index(Request $request){
        if($request->order_id){
            $data['title'] = __('site.orders');
            $data['order'] = Order::find($request->order_id);
            $data['order']->update(['not_seen' => 1]);
            $data['driver'] = Driver::find($data['order']->driver_id);
            $data['customer'] = Customer::find($data['order']->user_id);
            $data['details'] = OrderDetails::where('order_id',$request->order_id)->orderByDesc('id')->get();
           foreach ($data['details'] as $d){
               $d->sub_quntity = SubQuantity::find($d->sub_quantity_id);
               $d->color = Color::find($d->color_id);
               $d->product = Product::find($d->product_id);
           }
            return view('dashboard.orders.details.index', compact('data'));
        }
    }
}
