<?php

namespace App\Http\Controllers;

use App\Ad;
use App\MainCategory;
use App\Page;
use App\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function terms(){
        $g = new HomeController();
        $data['page'] = Page::find(3);
        $data['title'] = $data['page']->getTranslateName();
        $data['general'] = $g->get_general();
        $data['main_categories'] = MainCategory::whereIn('id',Product::pluck('main_catgeory_id')->toArray())->get();
        return view('pages.show', compact('data'));
    }

    public function about(){
        $g = new HomeController();
        $data['page'] = Page::find(1);
        $data['title'] = $data['page']->getTranslateName();
        $data['general'] = $g->get_general();
        $data['main_categories'] = MainCategory::whereIn('id',Product::pluck('main_catgeory_id')->toArray())->get();
        return view('pages.show', compact('data'));
    }
    public function polices(){
        $g = new HomeController();
        $data['page'] = Page::find(2);
        $data['title'] = $data['page']->getTranslateName();
        $data['general'] = $g->get_general();
        $data['main_categories'] = MainCategory::whereIn('id',Product::pluck('main_catgeory_id')->toArray())->get();
        return view('pages.show', compact('data'));
    }
}
