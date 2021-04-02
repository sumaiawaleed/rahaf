<?php

namespace App\Http\Controllers\Dashboard;

use App\Customer;
use App\Driver;
use App\Http\Controllers\Controller;
use App\MainCategory;
use App\Order;
use App\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:orders-read'])->only('index', 'show');
        $this->middleware(['permission:orders-create'])->only('create', 'store');
        $this->middleware(['permission:orders-update'])->only('edit', 'update');
        $this->middleware(['permission:orders-delete'])->only('destroy');
    }
    private function validate_page($request)
    {
        $rules = [
            "total_price" => "required",
            "user_address" => "required",
            "driver_id" => "required",
            "status" => "required",
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.orders');
        $data['drivers'] = Driver::all();
        $data['orders'] = Order::when($request->search, function ($q) use ($request) {

            return $q->where('name', 'LIKE', '%' . $request->search . '%')->orWhere('a_name', 'LIKE', '%' . $request->search . '%');

        })->when($request->from_date, function ($q) use ($request) {

            return $q->whereBetween('date', [$request->from_date, $request->to_date]);

        })->when($request->driver, function ($q) use ($request) {

            return $q->where('driver_id', $request->driver);

        })->when($request->status != NULL, function ($q) use ($request) {

            return $q->where('status', $request->status);

        })->latest('id')->get()->take(500);

        foreach ($data['orders'] as $o){
            $o->customer = Customer::find($o->user_id);
        }
        $data['url'] = route(env('DASH_URL') . '.orders.index');
        return view('dashboard.orders.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = __('site.orders');
        $data['main_orders '] = MainCategory::where('status',1)->latest('id')->get();
        $data['url'] = route(env('DASH_URL') . '.orders.store');
        $data['drivers'] = Driver::all();
        return view('dashboard.orders.create', compact('data'));
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
            $data = [
                "user_id" => $request->user_id,
                "total_price" => $request->total_price,
                "user_lat" => $request->user_lat,
                "user_log" => $request->user_log,
                "user_address" => $request->user_log,
                "note" => $request->note,
                "the_millisecands" => $request->the_millisecands,
                "driver_id" => $request->driver_id,
                "status" => $request->status,
                "not_seen" => $request->not_seen,
                "day_doller_cost" => $request->day_doller_cost,
            ];

            Order::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Order::find($id);
        $data['drivers'] = Driver::all();
        $data['title'] = __('site.edit_orders');
        $data['main_orders'] = MainCategory::where('status',1)->latest('id')->get();
        $data['cat_types'] = MainCategory::where('status',1)->latest('id')->get();
        $data['url'] = route(env('DASH_URL') . '.orders.update', $form_data->id);
        return view('dashboard.orders.edit', compact('data', 'form_data'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data = [
                "total_price" => $request->total_price,
                "user_lat" => $request->user_lat,
                "user_log" => $request->user_log,
                "user_address" => $request->user_address,
                "note" => $request->note,
                "driver_id" => $request->driver_id,
                "status" => $request->status,
            ];

            $order->update($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $details = OrderDetails::where('order_id',$order->id);
            $details->delete();
        }//end of if

        $order->delete();
        return response()->json(array('success' => true), 200);

    }

}
