<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Color;
use App\ExtraImage;
use App\MainCategory;
use App\Product;
use App\Rating;
use App\SubQuantity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data['meta']['title'] = __('site.categories');
        $data['meta']['description'] = __('site.categories');
        $data['meta']['image'] = asset('public/assets/images/logo.jpg');
        $data['title'] = __('site.products');
        $g = new HomeController();
        $data['general'] = $g->get_general();

        $data['new_products'] = Product::latest('id')->get()->take(9);

        $data['main_categories'] = MainCategory::all();

        /*
         * $main_category
        */
        $data['products'] = Product::where('available', 1)
            ->when($request->search, function ($q) use ($request) {

                return $q->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('a_name', 'LIKE', '%' . $request->search . '%');

            })->when($request->brands, function ($q) use ($request) {

                if (is_array($request->brands)) {
                    return $q->whereIn('brand_id', $request->brands);
                }
            })->when($request->categories, function ($q) use ($request) {

                if (is_array($request->categories)) {
                    return $q->whereIn('main_catgeory_id', $request->categories);
                }
            })->when($request->color_id, function ($q) use ($request) {

                if ($request->color_id != 0) {
                    return $q->whereIn('id', ExtraImage::where('color_id',$request->color_id)->pluck('product_id')->toArray());
                }else{
                    return $q->whereIn('id', ExtraImage::where('color_id',17)->pluck('product_id')->toArray());
                }
            })->when($request->offer, function ($q) use ($request) {
                return $q->where('type' ,1);
            })->when($request->from, function ($q) use ($request) {

                if (is_numeric($request->from)) {
                    return $q->where('price','>', $request->from);
                }
                if (is_numeric($request->to)) {
                    return $q->where('price','<', $request->to);
                }
            })
            ->latest()->paginate(20);
        return view('categories.products', compact('data', 'request'));
    }

    public function offers()
    {
        $data['meta']['title'] = __('site.categories');
        $data['meta']['description'] = __('site.categories');
        $data['meta']['image'] = asset('public/assets/images/logo.jpg');
        $data['title'] = __('site.categories');
        $g = new HomeController();
        $data['general'] = $g->get_general();

        $data['new_products'] = Product::whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        )->latest()->get()->take(9);

        $data['main_categories'] = MainCategory::all();

        $data['products'] = Product::where('status', 1)->where('available', 1)->where('type', 2)->latest()->paginate(20);
        return view('categories.products', compact('data'));
    }

    public function show($id)
    {

        $data['product'] = Product::where('available', 1)->where('id', $id)->first();
        if ($data['product']) {
            $data['meta']['title'] = $data['product']->getTranslateName();
            $data['meta']['description'] = $data['product']->getTranslateDesc();
            $data['meta']['image'] = $data['product']->image_path;
            $data['title'] = $data['product']->getTranslateName();
            $g = new HomeController();
            $data['general'] = $g->get_general();

            $data['new_products'] = Product::latest('id')->get()->take(9);
            $data['more_products'] = Product::where('main_catgeory_id',$data['product']->main_catgeory_id)->latest('id')->get()->take(9);

            $data['main_categories'] = MainCategory::all();

            $data['extras'] = ExtraImage::
            select('extra_imgs.*', 'color.color', 'sub_quantity.*')
                ->join('color', 'color.id', '=', 'extra_imgs.color_id')
                ->join('sub_quantity', 'sub_quantity.id', '=', 'extra_imgs.quantity')
                ->where('product_id', $id)->get();


            $data['reviews'] = Rating::select('*','ratings.id as rate_id')->where('pr_id', $id)->join('user', 'user.id', '=', 'ratings.user_id')->latest('the_date')->get();

            return view('categories.show', compact('data'));
        }
    }

    public function latest()
    {
        $data['meta']['title'] = __('site.categories');
        $data['meta']['description'] = __('site.categories');
        $data['meta']['image'] = asset('public/assets/images/logo.jpg');
        $data['title'] = __('site.categories');
        $g = new HomeController();
        $data['general'] = $g->get_general();

        $data['new_products'] = Product::whereMonth(
            'created_at', '=', Carbon::now()->subMonth()->month
        )->latest()->get()->take(9);

        $data['main_categories'] = MainCategory::all();

        $data['products'] = Product::where('available', 1)->latest()->paginate(20);
        return view('categories.products', compact('data'));

    }

}
