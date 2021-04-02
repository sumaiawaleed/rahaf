<?php

namespace App\Http\Controllers\Dashboard;

use App\Ad;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:customers-read'])->only('index', 'show');
        $this->middleware(['permission:customers-create'])->only('create', 'store');
        $this->middleware(['permission:customers-update'])->only('edit', 'update');
        $this->middleware(['permission:customers-delete'])->only('destroy');
    }
    public function index(Request $request){
        $data['main_categories'] = Category::where('is_deleted',0)->where('parent_id',0)->get();
        $data['ads'] = Ad::when($request->search, function ($q) use ($request) {

            return $q->where('name', 'LIKE', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })
            ->where('is_deleted', 0)
            ->latest()
            ->paginate(20);


        if ($request->ajax()) {
            if ($request->page == 0) {
                return view('dashboard.ads._ad_data', compact('data'))->render();
            } else {
                return view('dashboard.ads._pagination_data', compact('data'))->render();
            }
            } else {
            $data['title'] = __('site.ads');
            return view('dashboard.customers.products.index', compact('data'));
        }
    }
}
