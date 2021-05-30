<?php

namespace App\Http\Controllers\Dashboard;

use App\Customer;
use App\Favourite;
use App\Http\Controllers\Controller;
use App\Product;
use App\Rating;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class CustomerController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:customers-read'])->only('index', 'show');
        $this->middleware(['permission:customers-create'])->only('create', 'store');
        $this->middleware(['permission:customers-update'])->only('edit', 'update');
        $this->middleware(['permission:customers-delete'])->only('destroy');
    }
    private function validate_page($request,$customer = null){
        $rules = [
            'name' => 'required',
            'country_code' => 'required|max:20',
            'gender' => 'integer'
        ];

        if($customer){
            $rules += ['phone' => [ 'required','max:20',
                Rule::unique('user')->ignore($customer->id, 'id')
            ]
            ];
        }else{
            $rules += ['phone' => [ 'required','max:20','unique:user' ]];
        }

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }
    public function index(Request $request){
        $data['title'] = __('site.customers');
        $data['customers'] = Customer::when($request->search, function ($q) use ($request) {

            return $q->where('name', '%' . $request->search . '%');

        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL').'.categories.index');
        return view('dashboard.customer.index',compact('data'));

    }

    public function report(Request $request){
        $data['title'] = __('site.customers');
        $data['customers'] = Customer::when($request->search, function ($q) use ($request) {

            return $q->where('name', '%' . $request->search . '%');

        })->latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL').'.categories.index');

        if($request->pdf){
            $view = \View::make('dashboard.customers._pdf',compact('data'));
            $html_content = $view->render();
            PDF::SetTitle($data['title']);
            PDF::AddPage();
            PDF::setRTL(true);
            PDF::writeHTML($html_content, true, false, true, false, '');
            // userlist is the name of the PDF downloading
            PDF::Output(date('Y-m-d', strtotime(now())));
        }else{
            return view('dashboard.customers.reports', compact('data','request'));
        }
    }


    public function create(){
        $data['title'] = __('site.add_customer');
        return view('dashboard.customer.create',compact('data'));
    }

    public function store(Request $request){
        $validator = $this->validate_page($request);
        if ($validator->fails()) {


            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        }else{
            $data['name'] = $request->name;
            $data['phone'] = $request->phone;
            $data['country_code'] = $request->country_code;
            $data['address'] = $request->address;
            $data['lat'] = ($request->lat) ? $request->lat : 0;
            $data['log'] = ($request->log) ? $request->log : 0;
            $data['gender'] = ($request->gender == 1 or $request->gender == 2)  ? $request->gender : 0;
            $data['token'] = "";

            Customer::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit(Customer $customer){
        $form_data = $customer;
        $data['title'] = __('site.edit_customer');
        return view('dashboard.customer.create',compact('data','form_data'));
    }

    public function update(Request $request,Customer $customer){
        $validator = $this->validate_page($request,$customer);
        if ($validator->fails()) {


            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        }else{
            $data['name'] = $request->name;
            $data['phone'] = $request->phone;
            $data['country_code'] = $request->country_code;
            $data['address'] = $request->address;
            $data['lat'] = ($request->lat) ? $request->lat : 0;
            $data['log'] = ($request->log) ? $request->log : 0;
            $data['gender'] = ($request->gender == 1 or $request->gender == 2)  ? $request->gender : 0;
            $data['token'] = "";

           $customer->update($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function show(Customer $customer){
        $form_data = $customer;
        $data['title'] = $customer->name;
        $data['favourites'] = Favourite::where('user_id',$customer->id)->latest('id')->paginate(20);

        foreach ($data['favourites']  as $fav){
            $fav->customer = Customer::find($fav->user_id);
            $fav->product = Product::find($fav->product_id);
        }

        $data['ratings'] = Rating::where('user_id',$customer->id)->latest('id')->paginate(20);
        foreach ($data['ratings']  as $fav){
            $fav->customer = Customer::find($fav->user_id);
            $fav->product = Product::find($fav->pr_id);
        }
        return view('dashboard.customer.show',compact('data','form_data'));

    }
}
