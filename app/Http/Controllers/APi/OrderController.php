<?php

namespace App\Http\Controllers\APi;

use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Order;
use App\Ad;
use App\Store;

class OrderController extends Controller
{
    public function sent_order(Request $request)
    {
        $apis = new ApiHelper();
        $user = $request->user();
        $data['orders'] = Order::where('user_id', $user->id)->where('is_deleted', 0)->latest()->paginate(20);

        foreach ($data['orders'] as $order) {
            $ad = Ad::find($order->ad_id);
            $ad_data['product_id'] = "";
            $ad_data['product_name'] = "";
            $ad_data['product_image'] = "";
            if ($ad) {
                $ad_data['product_id'] = $ad->id;
                $ad_data['product_name'] = $ad->getTranslateName('ar');
                $ad_data['product_image'] = $ad->main_image_path;
            }
            $order->product = $ad_data;

            $s = "";

            if ($order->status == 0) {
                $s = "قيد التنفيذ";
            } else if ($order->status == -1) {
                $s = "ملغي";
            } else if ($order->status == 1) {
                $s = "تم التنفيذ";
            }

            unset($order->ad_id);
            unset($order->updated_at);
            unset($order->is_deleted);
        }
        $apis->createApiResponse(false, 200, "", $data);
        return;
    }

    public function receive_order(Request $request)
    {
        $apis = new ApiHelper();
        $user = $request->user();

        $user_products = Ad::where('user_id', $user->id)->where('is_deleted', 0)->pluck('id')->toArray();
        $data['orders'] = Order::where('ad_id', $user_products)->where('is_deleted', 0)->latest()->paginate(20);

        foreach ($data['orders'] as $order) {
            $ad = Ad::find($order->ad_id);
            $ad_data['product_id'] = "";
            $ad_data['product_name'] = "";
            $ad_data['product_image'] = "";
            if ($ad) {
                $ad_data['product_id'] = $ad->id;
                $ad_data['product_name'] = $ad->getTranslateName('ar');
                $ad_data['product_image'] = $ad->main_image_path;
            }
            $order->product = $ad_data;

            $s = "";

            if ($order->status == 0) {
                $s = "قيد التنفيذ";
            } else if ($order->status == -1) {
                $s = "ملغي";
            } else if ($order->status == 1) {
                $s = "تم التنفيذ";
            }

            unset($order->ad_id);
            unset($order->updated_at);
            unset($order->is_deleted);
        }
        $apis->createApiResponse(false, 200, "", $data);
        return;
    }

    private function check_products($id)
    {
        $ad = Ad::find($id);
        $store = Store::where('user_id', $ad->user_id)->first();

        return $store ? $ad->user_id : 0;
    }

    public function store(Request $request)
    {
        $apis = new ApiHelper();
        $user = $request->user();
        try {
            $order_array = json_decode($request->order,true);

            foreach ($order_array as $o) {

                $request_data['ad_id'] = $o['product_id'];
                $request_data['quantity'] = $o['quantity'];
                $request_data['notes'] = $o['notes'];
                $request_data['is_deleted'] = 0;
                $request_data['status'] = 0;
                $request_data['user_id'] = $user->id;

                Order::create($request_data);
            }
        $apis->createApiResponse(false, 200, "تم الإضافة بنجاح", "");
        return;
        } catch (\Exception $ex) {
            $msg = "";
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    $msg =  "No errors";
                    break;
                case JSON_ERROR_DEPTH:
                    $msg =  "Maximum stack depth exceeded";
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $msg =  "Invalid or malformed JSON";
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $msg =  "Control character error";
                    break;
                case JSON_ERROR_SYNTAX:
                    $msg =  "Syntax error";
                    break;
                case JSON_ERROR_UTF8:
                    $msg =  "Malformed UTF-8 characters";
                    break;
                default:
                    $msg =  "Unknown error";
                    break;
            }

            $apis->createApiResponse(false, 500, $msg, "");
            return;
        }

    }
}
