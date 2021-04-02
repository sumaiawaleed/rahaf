<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RatetController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth',['customers']);
//    }
    public function rate(Request $request)
    {
        if (Auth::guard('customers')->user()) {
            $rules = [
                'pr_id' => 'required|integer|max:100',
                'rate' => 'required|max:100',
                'comment' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 200);
            } else {
                $data['pr_id'] = $request->pr_id;
                $data['rate'] = $request->rate;
                $data['comment'] = $request->comment;
                $data['user_id'] = Auth('customers')->user()->id;
                Rating::create($data);
//            return response()->json(array('success' => true), 200);
                return redirect()->back();
            }
        } else {

            return redirect('login');
        }
    }


    public function delete_rate(Request $request)
    {
        if (Auth::guard('customers')->user()) {

            $rate = Rating::find($request->id);
            if ($rate and $rate->user_id == Auth('customers')->user()->id)
                $rate->delete();
            return redirect()->back();
        } else {

            return redirect('login');
        }
    }
}
