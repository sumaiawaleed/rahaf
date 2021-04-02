<?php

namespace App\Http\Controllers;

use App\Category;
use App\MainCategory;
use App\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data['meta']['title'] = __('site.categories');
        $data['meta']['description'] = __('site.categories');
        $data['meta']['image'] = asset('public/assets/images/logo.jpg');
        $data['title'] = __('site.categories');
        $g = new HomeController();
        $data['general'] = $g->get_general();
        $data['categories'] = MainCategory::all();
        foreach ($data['categories'] as $c) {
            $c->subs = Category::where('main_cat_id', $c->id)->get();
        }
        return view('categories.all', compact('data'));
    }

    public function load_category(Request $request)
    {
        if ($request->main_id) {
            $cats = Category::where('main_cat_id', $request->id)->get();
            $result = '<select name="category_id">';
            foreach ($cats as $c) {
                $result .= '<option value = "' . $c->id . '" >' . $c->getTranslateName() . '</option >';
            }

            $result .= '</select >';

            return $result;

        }
    }
    public function load_subs(Request $request)
    {
        if ($request->main_id) {
            $cats = SubCategory::where('cat_id', $request->id)->get();
            $result = '<select name="sub_id">';
            foreach ($cats as $c) {
                $result .= '<option value = "' . $c->id . '" >' . $c->getTranslateName() . '</option >';
            }
            $result .= '</select >';
            return $result;
        }
    }
}
