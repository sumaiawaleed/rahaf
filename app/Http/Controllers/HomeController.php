<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Brand;
use App\Color;
use App\MainCategory;
use App\Page;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function get_general()
    {
        $data['main_categories'] = MainCategory::all();
        $data['footer_categories'] = MainCategory::latest('id')->get()->take(4);
        $data['pages'] = Page::latest('id')->get()->take(4);
        $data['brands'] = Brand::all();
        $data['colors'] = Color::all();
        return $data;
    }

    public function index(Request $request)
    {
        $data['title'] = __('site.home');
        $data['general'] = $this->get_general();
        $data['main_categories'] = MainCategory::whereIn('id',Product::pluck('main_catgeory_id')->toArray())->get();
        $data['ads'] = Ad::where('ad_id', 0)->get();
        $data['offers']  = Product::where('type',2)->latest('updated_at')->take(10)->get();
        $data['new_products'] = Product::latest('id')->take(10)->get();

        foreach ($data['main_categories'] as $c){
            $c->products = Product::where('main_catgeory_id',$c->id)->take(6)->get();
        }

        return view('home', compact('data'));
    }

    public function change_currency(Request $request)
    {
        if ($request->id == 1 or $request->id == 2) {
            Session::put('currency', $request->id);
        }
        return redirect()->back();
    }
}
