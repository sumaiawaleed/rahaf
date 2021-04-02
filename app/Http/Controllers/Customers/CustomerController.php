<?php

namespace App\Http\Controllers\Customers;

use App\Favourite;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{


    private function validate_page($request, $customer = null)
    {
        $rules = [
            'name' => 'required',
            'country_code' => 'required|max:20',
            'gender' => 'integer'
        ];

        if ($customer) {
            $rules += ['phone' => ['required', 'max:20',
                Rule::unique('user')->ignore($customer->id, 'id')
            ]
            ];
        } else {
            $rules += ['phone' => ['required', 'max:20', 'unique:user']];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function statistics()
    {
        $data['favs'] = Favourite::where('user_id', auth('customers')->user()->id)->get()->count();
        $data['orders'] = Order::where('user_id', auth('customers')->user()->id)->get()->count();

        return $data;
    }

    public function profile()
    {
        if (Auth::guard('customers')->user()) {
            $data['meta']['title'] = __('site.login');
            $data['meta']['description'] = __('site.login');
            $data['meta']['image'] = asset('public/assets/images/logo.jpg');
            $data['title'] = __('site.my_account');

            $data['stats'] = $this->statistics();
            $g = new HomeController();
            $data['general'] = $g->get_general();
            return view('customers.profile', compact('data'));
        } else {

            return redirect('login');
        }
    }

    public function update(Request $request)
    {
        if (Auth::guard('customers')->user()) {
            $customer = Auth::guard('customers')->user();
            $validator = $this->validate_page($request, $customer);
            if ($validator->fails()) {


                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 200);
            } else {
                $data['name'] = $request->name;
                $data['phone'] = $request->phone;
                $data['country_code'] = $request->country_code;
                $data['address'] = $request->address;
                $data['gender'] = ($request->gender == 1 or $request->gender == 2) ? $request->gender : 0;

                $customer->update($data);
                return response()->json(array('success' => true, 'type' => 'edit', 'msg' => __('site.added_successfully')), 200);
            }
        } else {

            return redirect('login');
        }
    }

    public function update_location(Request $request)
    {
        if (Auth::guard('customers')->user()) {
            $customer = Auth::guard('customers')->user();
            $rules = [
                'lat' => 'required',
                'log' => 'required',
            ];


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {


                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 200);
            } else {
                $data['lat'] = ($request->lat) ? $request->lat : 0;
                $data['log'] = ($request->log) ? $request->log : 0;
                $customer->update($data);
                return response()->json(array('success' => true, 'type' => 'edit', 'msg' => __('site.updated_successfully')), 200);
            }
        } else {

            return redirect('login');
        }
    }

    public function change_password(Request $request)
    {
        if (Auth::guard('customers')->user()) {
            $data['meta']['title'] = __('site.change_password');
            $data['meta']['description'] = __('site.change_password');
            $data['meta']['image'] = asset('public/assets/images/logo.jpg');
            $data['title'] = __('site.change_password');

            $c = new CustomerController();
            $data['stats'] = $c->statistics();
            $g = new HomeController();
            $data['general'] = $g->get_general();
            return view('customers.change_password', compact('data'));

        } else {

            return redirect('login');
        }
    }

    public function update_password(Request $request)
    {
        if (Auth::guard('customers')->user()) {
            $user = Auth('customers')->user();

            $rules = [
                'password' => 'required|string|min:6|confirmed',
                'old_password' => 'required|string|min:6',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {

                return response()->json(array(
                    'success' => false,
                    'msg' => "",
                    'errors' => $validator->getMessageBag()->toArray()

                ), 200);
            }

            $oldpassword = $request->input('old_password');
            if (!Hash::check($oldpassword, $user->password)) {
                return response()->json(array(
                    'success' => false,
                    'msg' => __('site.err_old_password'),
                    'errors' => array(),

                ), 200);
            }


            $user->password = Hash::make($request['password']);
            $user->save();

            return response()->json(array(
                'success' => true,
                'msg' => __('site.updated_successfully'),

            ), 200);
        } else {

            return redirect('login');
        }
    }
}
