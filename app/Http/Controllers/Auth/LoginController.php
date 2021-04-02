<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '__rhs_/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:__rhs_')->except('logout');
        $this->middleware('guest:customers')->except('logout');

    }

    public function showAdminLoginForm(){
        return view('auth.admin_login');
    }

    public function adminLogin(Request $request){
        $this->validate($request, [
            'email'   => 'required',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('__rhs_')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect(route(env('DASH_URL').'.home'));
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function postLogin(Request $request)
    {
        $rules = [
            'phone'   => 'required',
            'password' => 'required|min:6'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
                'msg' => ''

            ), 200);
        }else{
            if (Auth::guard('customers')->attempt(['phone' => $request->phone, 'password' => $request->password], $request->get('remember'))) {
                return response()->json(array('success' => true,'msg' => 'تم تسجيل الدخول بنجاح'), 200);
            }
        }

        return response()->json(array('success' => false,'msg' => __('site.error_login')), 200);
    }

    public function showLoginForm()
    {
        $data['meta']['title'] = __('site.login');
        $data['meta']['description'] = __('site.login');
        $data['meta']['image'] = asset('public/assets/images/logo.jpg');
        $data['title'] = __('site.login');
        $g = new HomeController();
        $data['general'] = $g->get_general();
        return view('auth.login',compact('data'));
    }
}
