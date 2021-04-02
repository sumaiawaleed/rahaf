<?php

namespace App\Http\Controllers\Customers;

use App\ExtraImage;
use App\Favourite;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Order;
use App\OrderDetails;
use App\Product;
use App\Quantity;
use App\SubQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        if (Auth::guard('customers')->user()) {
            $data['meta']['title'] = __('site.orders');
            $data['meta']['description'] = __('site.orders');
            $data['meta']['image'] = asset('public/assets/images/logo.jpg');
            $data['title'] = __('site.orders');

            $c = new CustomerController();
            $data['stats'] = $c->statistics();
            $g = new HomeController();
            $data['general'] = $g->get_general();

            $data['orders'] = Order::where('user_id', auth('customers')->user()->id)->latest('id')->paginate(10);
            return view('customers.orders.index', compact('data'));
        } else {

            return redirect('login');
        }
    }

    public function show(Request $request)
    {
        if (Auth::guard('customers')->user()) {
            $data['meta']['title'] = __('site.orders');
            $data['meta']['description'] = __('site.orders');
            $data['meta']['image'] = asset('public/assets/images/logo.jpg');
            $data['title'] = __('site.orders');

            $c = new CustomerController();
            $data['stats'] = $c->statistics();
            $g = new HomeController();
            $data['general'] = $g->get_general();

            $data['order'] = Order::where('user_id', auth('customers')->user()->id)->where('id', $request->id)->first();
            $data['details'] = OrderDetails::where('order_id', $request->id)->get();

            foreach ($data['details'] as $d) {
                $d->qunatity_data = Quantity::find($d->quantity);
                $d->sub_qunatity_data = SubQuantity::find($d->sub_quantity_id);
                $d->product_data = Product::find($d->product_id);
                $d->color_data = ExtraImage::where('product_id', $d->product_id)->where('color_id', $d->color_id)->first();
            }

            return view('customers.orders.show', compact('data'));
        } else {

            return redirect('login');
        }
    }
}
