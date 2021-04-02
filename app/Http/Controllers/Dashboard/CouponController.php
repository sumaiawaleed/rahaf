<?php

namespace App\Http\Controllers\Dashboard;

use App\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:coupons-read'])->only('index', 'show');
        $this->middleware(['permission:coupons-create'])->only('create', 'store');
        $this->middleware(['permission:coupons-update'])->only('edit', 'update');
        $this->middleware(['permission:coupons-delete'])->only('destroy');
    }
    private function validate_page($request)
    {
        $rules = [
            'amount' => 'required|integer',
            'thecount' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.coupons');
        $data['coupons'] = Coupon::latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.coupons.index');
        return view('dashboard.coupons.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = __('site.add_coupons');
        $data['url'] = route(env('DASH_URL') . '.coupons.store');
        return view('dashboard.coupons.create', compact('data'));
    }
    public function store(Request $request)
    {
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['amount'] = $request->amount;
            $data['code'] = md5(uniqid(20));
            $data['thecount'] = $request->thecount;
            Coupon::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Coupon::find($id);
        $data['title'] = __('site.edit_coupons');
        $data['url'] = route(env('DASH_URL') . '.coupons.update',$form_data->id);
        return view('dashboard.coupons.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $coupon = Coupon::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['amount'] = $request->amount;
//            $data['code'] = md5(uniqid(20));
            $data['thecount'] = $request->thecount;

            $coupon->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
        return response()->json(array('success' => true), 200);

    }
}
