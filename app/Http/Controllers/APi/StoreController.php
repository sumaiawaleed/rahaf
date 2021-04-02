<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Store;
use App\Category;
use App\City;
use App\User;
use App\Functions\ApiHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class StoreController extends Controller
{
    public function index(Request $request)
    {
        $apis = new ApiHelper();
        $data['stores'] = Store::when($request->search, function ($q) use ($request) {

            return $q->where('name', 'LIKE', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->when($request->city_id, function ($q) use ($request) {

            return $q->where('city_id', $request->city_id);

        })->where('status', 1)
            ->where('is_deleted', 0)
            ->latest()
            ->paginate(20);

        foreach ($data['stores'] as $store) {
            $store->name = $store->getTranslateName('ar');
            $store->details = $store->getTranslateDetails('ar');
            $store->address = $store->getTranslateAddress('ar');

            $category = Category::find($store->category_id);
            $store->category_name = ($category) ? $category->getTranslateName('ar') : "";
            $city = City::find($store->city_id);
            $store->city_name = ($city) ? $city->getTranslateName('ar') : "";
            $user = User::find($store->user_id);
            $store->user_name = ($user) ? $user->name : "";
            $store->user_image = ($user) ? $user->image_path : "";

            unset($store->status);
            unset($store->is_deleted);
            unset($store->updated_at);
        }

        $apis->createApiResponse(false, 200, "", $data);
        return;
    }

    public function show($id)
    {
        $apis = new ApiHelper();
        $store = Store::find($id);
        if ($store) {
            $store->name = $store->getTranslateName('ar');
            $store->details = $store->getTranslateDetails('ar');
            $store->address = $store->getTranslateAddress('ar');

            $category = Category::find($store->category_id);
            $store->category_name = ($category) ? $category->getTranslateName('ar') : "";
            $city = City::find($store->city_id);
            $store->city_name = ($city) ? $city->getTranslateName('ar') : "";
            $user = User::find($store->user_id);
            $store->user_name = ($user) ? $user->name : "";
            $store->user_image = ($user) ? $user->image_path : "";

            unset($store->status);
            unset($store->is_deleted);
            unset($store->updated_at);
            $apis->createApiResponse(false, 200, "", $store);
            return;
        }
        $apis->createApiResponse(false, 404, "", "");
        return;
    }

    public function store(Request $request)
    {
        $apis = new ApiHelper();
        $user = User::find($request->user()->id);
        $store = Store::where('user_id', $user->id)->first();
        if (!$store) {
            $rules = [
                'category_id' => 'required|integer',
                'city_id' => 'required|integer',
                'name' => 'required',
                'details' => 'required',
                'address' => 'required',
                'logo' => 'image',
            ];


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $data['errors'] = $validator->getMessageBag()->toArray();
                $apis->createApiResponse(false, 200, "", "");
                return;
            }

            $request_data['category_id'] = $request->category_id;
            $request_data['city_id'] = $request->city_id;
            $request_data['is_deleted'] = 0;
            $request_data['user_id'] = $user->id;
            if ($request->logo) {

                $png_url = "store-" . time() . ".png";
                $path = public_path() . '/uploads/stores/' . $png_url;
                Image::make(file_get_contents($request->logo))->save($path);
                $request_data['logo'] = $png_url;

            }


            $name_array = array();
            $details_array = array();
            $address_array = array();
            $name_array['ar'] = $request->name;
            $request_data['name'] = json_encode($name_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            $details_array['ar'] = $request->details;
            $request_data['details'] = json_encode($details_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            $address_array['ar'] = $request->address;
            $request_data['address'] = json_encode($address_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            $f = Store::create($request_data);

            $apis->createApiResponse(false, 200, "تم الإضافة بنجاح", "");
            return;
        } else {
            $apis->createApiResponse(true, 200, "لا يمكن إضافة متجر اخر للمستخدم", "");
            return;
        }
    }


    public function update(Request $request)
    {
        $apis = new ApiHelper();
        $user = User::find($request->user()->id);
        $store = Store::where('user_id', $user->id)->first();
        if ($store) {
            $rules = [
                'category_id' => 'required|integer',
                'city_id' => 'required|integer',
                'name' => 'required',
                'details' => 'required',
                'address' => 'required',
                'logo' => 'image',
            ];


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $data['errors'] = $validator->getMessageBag()->toArray();
                $apis->createApiResponse(false, 200, "", "");
                return;
            }

            $request_data['category_id'] = $request->category_id;
            $request_data['city_id'] = $request->city_id;
            $request_data['is_deleted'] = 0;
            $request_data['user_id'] = $user->id;
            if ($request->logo) {

                if ($store->logo != '') {

                    Storage::disk('public_uploads')->delete('/stores/' . $store->logo);

                }//end of if

                $png_url = "store-" . time() . ".png";
                $path = public_path() . '/uploads/stores/' . $png_url;
                Image::make(file_get_contents($request->logo))->save($path);
                $request_data['logo'] = $png_url;

            }


            $name_array = array();
            $details_array = array();
            $address_array = array();
            $name_array['ar'] = $request->name;
            $request_data['name'] = json_encode($name_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            $details_array['ar'] = $request->details;
            $request_data['details'] = json_encode($details_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            $address_array['ar'] = $request->address;
            $request_data['address'] = json_encode($address_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            $f = Store::create($request_data);

            $apis->createApiResponse(false, 200, "تم التعديل بنجاح", "");
            return;
        } else {
            $apis->createApiResponse(true, 200, "لا يوجد  متجر خاص بالمستخدم", "");
            return;
        }
    }

    public function user_store(Request $request){
        $apis = new ApiHelper();
        $store = Store::where('user_id',$request->user()->id)->first();
        if ($store) {
            $store->name = $store->getTranslateName('ar');
            $store->details = $store->getTranslateDetails('ar');
            $store->address = $store->getTranslateAddress('ar');

            $category = Category::find($store->category_id);
            $store->category_name = ($category) ? $category->getTranslateName('ar') : "";
            $city = City::find($store->city_id);
            $store->city_name = ($city) ? $city->getTranslateName('ar') : "";
            $user = User::find($store->user_id);
            $store->user_name = ($user) ? $user->name : "";
            $store->user_image = ($user) ? $user->image_path : "";

            unset($store->status);
            unset($store->is_deleted);
            unset($store->updated_at);
            $apis->createApiResponse(false, 200, "", $store);
            return;
        }
        $apis->createApiResponse(false, 404, "", "");
        return;
    }
}
