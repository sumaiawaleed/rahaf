<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Dollar;
use App\MainCategory;
use App\Order;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $product = Product::find($request->id);

        if ($product) {

            if (session()->has('cart')) {
                $cart = new Cart(session()->get('cart'));
            } else {
                $cart = new Cart();
            }
            $cart->add($product,1);
            session()->put('cart', $cart);

            $cart = new Cart(session()->get('cart'));
            $data['success'] = TRUE;
            $data['all'] = count($cart->items);
            $data['message'] = __('site.add_to_cart_successfully');
            return json_encode($data);


        } else {
            $data['success'] = FALSE;
            $data['message'] = __('site.add_to_cart_error');
            return json_encode($data);
        }
    }

    public function edit_cart(Request $request){
        $product = Product::find($request->id);

        if ($product) {

            if (session()->has('cart')) {
                $cart = new Cart(session()->get('cart'));
            } else {
                $cart = new Cart();
            }
            $cart->edit($product,$request->quantity);
            session()->put('cart', $cart);

            $cart = new Cart(session()->get('cart'));
            $data['success'] = TRUE;
            $data['all'] = count($cart->items);
            $data['total'] = $cart->totalPrice;
            $data['message'] = __('site.add_to_cart_successfully');
            return json_encode($data);


        } else {
            $data['success'] = FALSE;
            $data['message'] = __('site.add_to_cart_error');
            return json_encode($data);
        }
    }

    public function view_cart(Request $request)
    {
        if ($request->ajax()) {
            if (session()->has('cart')) {
                $cart = new Cart(session()->get('cart'));
            } else {
                $cart = null;
            }
            return view('customers.cart._cart_model', compact('cart'))->render();
        } else {
            if (session()->has('cart')) {
                $data['cart'] = new Cart(session()->get('cart'));
            } else {
                $data['cart'] = null;
            }

//            echo json_encode($data['cart'] );
//            return;

            $data['meta']['title'] = __('site.cart');
            $data['meta']['description'] = __('site.cart');
            $data['meta']['image'] = asset('public/assets/images/logo.jpg');
            $data['title'] = __('site.cart');
            $g = new HomeController();
            $data['general'] = $g->get_general();

            return view('customers.cart.view_cart', compact('data'));

        }
    }

    public function checkout(Request $request){
        $data['meta']['title'] = __('site.checkout');
        $data['meta']['description'] = __('site.checkout');
        $data['meta']['image'] = asset('public/assets/images/logo.jpg');
        $data['title'] = __('site.checkout');
        $g = new HomeController();
        $data['general'] = $g->get_general();

        $form_data = \auth('customers')->user();

        if (session()->has('cart')) {
            $data['cart'] = new Cart(session()->get('cart'));
        } else {
            $data['cart'] = null;
        }

        return view('customers.cart.checkout', compact('data','form_data'));
    }

    public function checkout_process(Request $request){
        $customer = Auth::guard('customers')->user();
        $validator = $this->validate_page($request, $customer);
        if ($validator->fails()) {


            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['user_id'] = Auth('customers')->user()->id;
            $data['user_address'] = $request->user_address;
            $data['phone'] = $request->phone;
            $data['country_code'] = $request->country_code;
            $data['address'] = $request->address;
            $data['gender'] = ($request->gender == 1 or $request->gender == 2) ? $request->gender : 0;

            $customer->update($data);
            return response()->json(array('success' => true, 'type' => 'edit', 'msg' => __('site.added_successfully')), 200);
        }
    }

    public function delete_cart(Request $request){
        $product = Product::find($request->id);
        $cart = new Cart(session()->get('cart'));
        $cart->remove($product);

        if ($cart->totalQty <= 0) {
            session()->forget('cart');
        } else {
            session()->put('cart', $cart);
        }

        $data['success'] = True;
        return json_encode($data);
    }

    public function add_order(Request $request){
        $d = Dollar::get()->first();
        $order['user_id'] = auth('customers')->user()->id;
        $order['user_address'] = $request->address;
        $order['status'] = 0;
        $order['day_doller_cost'] = $d->the_cost;
        $order['user_lat'] = ($request->lat) ? $request->lat  : 0;
        $order['user_log'] = ($request->lng) ? $request->log : 0;

        $new_order = Order::create($order);

        if($new_order){
            $cart = null;
            if (session()->has('cart')) {
                $cart = new Cart(session()->get('cart'));
            }

            if($cart){
                foreach ($cart->items as $item){
                    $order_details['order_id']  = $new_order->id;
                    $order_details['price']  = $item['price'];
                    $order_details['quantity']  = $item['qty'];
                }
            }
        }
    }
}
