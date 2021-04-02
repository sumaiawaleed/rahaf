<?php

namespace App\Http\Controllers\Customers;

use App\Favourite;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Customers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth',['customers']);
//    }
    public function index(Request $request)
    {
        if (Auth::guard('customers')->user()) {

            $data['meta']['title'] = __('site.login');
            $data['meta']['description'] = __('site.login');
            $data['meta']['image'] = asset('public/assets/images/logo.jpg');
            $data['title'] = __('site.my_favorites');

            $c = new CustomerController();
            $data['stats'] = $c->statistics();
            $g = new HomeController();
            $data['general'] = $g->get_general();

            $array = Favourite::where('user_id', auth('customers')->user()->id)->get()->pluck('product_id')->toArray();
            $data['products'] = Product::whereIn('id', $array)->get();
            return view('customers.favorites', compact('data'));
        } else {

            return redirect('login');
        }
    }

    public function remove(Request $request)
    {
        if (Auth::guard('customers')->user()) {

            $fav = Favourite::where('user_id', Auth::guard('customers')->user()->id)->where('product_id', $request->id)->first();
            if ($fav) {
                $fav->delete();
                $data['success'] = TRUE;
                $data['message'] = __('site.remove_form_wishlist_success');
                return json_encode($data);
            } else {
                $data['success'] = FALSE;
                $data['message'] = __('site.cannt_remove_form_wishlist');
                return json_encode($data);
            }
        } else {

            return redirect('login');
        }
    }

    public function add(Request $request)
    {
        if (Auth::guard('customers')->user()) {

            $fav = Favourite::where('user_id', Auth::guard('customers')->user()->id)->where('product_id', $request->id)->first();
            if ($fav) {
                $data['success'] = FALSE;
                $data['message'] = __('site.already_in_wishlist');
                return json_encode($data);
            } else {
                $request_data['user_id'] = Auth::guard('customers')->user()->id;
                $request_data['product_id'] = $request->id;
                Favourite::create($request_data);
                $data['success'] = TRUE;
                $data['message'] = __('site.add_to_wishlist_successfully');
                return json_encode($data);
            }
        } else {

            return redirect('login');
        }
    }

    public function wishlist(Request $request)
    {
        if (Auth::guard('customers')->user()) {

            $fav = Favourite::where('user_id', Auth::guard('customers')->user()->id)->where('product_id', $request->id)->first();
            if ($fav) {
                $fav->delete();
                $data['success'] = TRUE;
                $data['type'] = 2;
                $data['id'] = $request->id;
                $data['msg'] = __('site.remove_form_wishlist_success');
                return json_encode($data);
            } else {
                $request_data['user_id'] = Auth::guard('customers')->user()->id;
                $request_data['product_id'] = $request->id;
                Favourite::create($request_data);
                $data['success'] = TRUE;
                $data['type'] = 1;
                $data['id'] = $request->id;
                $data['msg'] = __('site.add_to_wishlist_successfully');
                return json_encode($data);
            }
        } else {

            return redirect('login');
        }
    }
}
