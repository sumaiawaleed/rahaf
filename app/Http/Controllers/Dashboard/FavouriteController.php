<?php

namespace App\Http\Controllers\Dashboard;

use App\Color;
use App\Customer;
use App\Favourite;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:favorites-read'])->only('index', 'show');
        $this->middleware(['permission:favorites-create'])->only('create', 'store');
        $this->middleware(['permission:favorites-update'])->only('edit', 'update');
        $this->middleware(['permission:favorites-delete'])->only('destroy');
    }
    public function index(Request $request)
    {
        $data['title'] = __('site.favourites');
        $data['favourites'] = Favourite::when($request->product_id, function ($q) use ($request) {

            return $q->where('product_id',$request->product_id );

        })->latest('id')->paginate(20);

        foreach ($data['favourites']  as $fav){
            $fav->customer = Customer::find($fav->user_id);
            $fav->product = Product::find($fav->product_id);
        }
        $data['url'] = route(env('DASH_URL') . '.favourites.index');
        return view('dashboard.favourites.index', compact('data'));
    }

    public function destroy($id)
    {
        $category = Favourite::find($id);
        $category->delete();
        return response()->json(array('success' => true), 200);

    }

}
