<?php

namespace App\Http\Controllers\Dashboard;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Product;
use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:rates-read'])->only('index', 'show');
        $this->middleware(['permission:rates-create'])->only('create', 'store');
        $this->middleware(['permission:rates-update'])->only('edit', 'update');
        $this->middleware(['permission:rates-delete'])->only('destroy');
    }

    private function validate_page($request)
    {
        $rules = [
            'rate' => 'required',
            'comment' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }
    public function index(Request $request)
    {
        $data['title'] = __('site.ratings');
        $data['ratings'] = Rating::when($request->product_id, function ($q) use ($request) {

            return $q->where('pr_id',$request->product_id );

        })->latest('id')->paginate(20);

        foreach ($data['ratings']  as $fav){
            $fav->customer = Customer::find($fav->user_id);
            $fav->product = Product::find($fav->pr_id);
        }
        $data['url'] = route(env('DASH_URL') . '.ratings.index');
        return view('dashboard.ratings.index', compact('data'));
    }

    public function edit($id)
    {
        $form_data = Rating::find($id);
        $data['title'] = __('site.edit_ratings');
        $data['url'] = route(env('DASH_URL') . '.ratings.update',$form_data->id);
        return view('dashboard.ratings.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $rate = Rating::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['rate'] = $request->rate;
            $data['comment'] = $request->comment;

            $rate->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $rate = Rating::find($id);
        $rate->delete();
        return response()->json(array('success' => true), 200);

    }
}
