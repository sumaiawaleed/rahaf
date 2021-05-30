<?php

namespace App\Http\Controllers\Dashboard;

use App\Customer;
use App\Driver;
use App\ExtraImage;
use App\Http\Controllers\Controller;
use App\MainCategory;
use App\Order;
use App\OrderDetails;
use App\Product;
use App\User;
use Fcm\FcmClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Fcm\Push\Notification;
use Elibyy\TCPDF\Facades\TCPDF as PDF;



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
        if($request->pdf){
            $view = \View::make('dashboard.orders.partials._pdf',compact('data'));
            $html_content = $view->render();
            PDF::SetTitle($data['title']);
            PDF::AddPage();
            PDF::setRTL(true);
            PDF::writeHTML($html_content, true, false, true, false, '');
            // userlist is the name of the PDF downloading
            PDF::Output(date('Y-m-d', strtotime(now())));
        }else{
            return view('dashboard.orders.index', compact('data'));
        }
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
        $form_data->user = User::find($form_data->user_id);
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
                "user_address" => $request->user_address,
                "note" => $request->note,
                "driver_id" => $request->driver_id,
                "status" => $request->status,
            ];

            if($request->user_lat){
                $data["user_lat"] = $request->user_lat;
            }

            if($request->user_log){
                $data["user_log"] = $request->user_log;
            }


            if($request->status == 0){
                $details = OrderDetails::where('order_id',$order->id)->get();
                foreach ($details as $detail){
                    if($detail->extra_id == 1){
                        Product::where('id',$detail->product_id)->update(['quantity' => DB::raw('quantity +'.$detail->quantity)]);

                    }else{
                        ExtraImage::where('product_id',$detail->product_id)->where('color_id',$detail->color_id)->update(['quantity' => DB::raw('quantity +'.$detail->quantity)]);
                    }
                }
            }

            if($order->status != $request->status){
                  $the_user = Customer::find($order->user_id);
                  $the_title='الطلب رقم :'.$request->id;
                 $this->send_note($the_user->token,$the_title,$this->get_status_title($request->status));
            }

            $order->update($data);




            return response()->json(array('success' => true), 200);
        }
    }

    private function get_status_title($status){
        if($status==1){
            return "الطلب قيد المراجعة";
        }if($status==2){
            return "جاري تجهيز الطلب";
        }if($status==3){
            return "الطلب في الطريق اليك";
        }if($status==4){
            return "تم تسليم الطلب ";
        }if($status==0){
            return "تم الغاء الطلب ";
        }

    }

    private function send_note($usertoken,$thetitle,$thebody){
        $fcm = new FcmClient(env('ACCESS_KEY'), env('ACCESS_ID'));

        $push = new Notification($thetitle, $thebody, "/token/" . $usertoken);

        $send = $fcm->send($push);
    }


    public function test_notification($id){
        $the_user = Customer::find($id);
        $this->send_note("ddede","text title","test body");
    }

    private function send_notification($usertoken,$thetitle,$thebody){

        define('API_ACCESS_KEY','');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token=$usertoken;

        $notification = [
            'title' =>$thetitle,
            'body' => $thebody,
            'icon' =>'myIcon',
            'sound' => 'mySound'
            //,'image'=> 'https://wowcartyemen.com/rahaf_api/rhf_logo.jpg'
        ];
        $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);



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
