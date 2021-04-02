<?php

namespace App\Http\Controllers\APi;

use App\Ad;
use App\AdImage;
use App\Category;
use App\contacts;
use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\User;
use App\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserProductController extends Controller
{
    public function index(Request $request){
        $user = User::find($request->user()->id);

        $products = Ad::when($request->search, function ($q) use ($request) {

            return $q->where('name', 'LIKE', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->where('user_id',$user->id)
            ->where('is_deleted', 0)
            ->latest()
            ->paginate(20);

        $p = new ProductsController();
        $data['products'] = $p->featch_products($products);

        $apis = new ApiHelper();
        $apis->createApiResponse(true,200,"",$data);
        return;
    }
    public function archive(Request $request){
        $user = User::find($request->user()->id);

        $products = Ad::when($request->search, function ($q) use ($request) {

            return $q->where('name', 'LIKE', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->where('user_id',$user->id)
            ->where('is_deleted', 1)
            ->latest()
            ->paginate(20);

        $p = new ProductsController();
        $data['products'] = $p->featch_products($products);

        $apis = new ApiHelper();
        $apis->createApiResponse(true,200,"",$data);
        return;
    }

    public function add_archive(Request  $request){
        $apis = new ApiHelper();
        $user = $request->user();
        $product = Ad::find($request->product_id);
        if($product and ($product->is_deleted) == 0 and ($product->user_id == $user->id)){

            $product->update(['is_deleted' => 1]);
            $apis->createApiResponse(false, 200, "تم الإضافة بنجاح", "");
            return;
        }else{
            $apis->createApiResponse(true, 404, "NOT FOUND", "");
            return;
        }
    }

    public function remove_archive(Request  $request){
        $apis = new ApiHelper();
        $user = $request->user();
        $product = Ad::find($request->product_id);
        if($product and ($product->is_deleted) == 1 and ($product->user_id == $user->id)){
            $product->update(['is_deleted' => 0]);
            $apis->createApiResponse(false, 200, "تم الإستعادة بنجاح", "");
            return;
        }else{
            $apis->createApiResponse(true, 404, "NOT FOUND", "");
            return;
        }
    }

    public function store(Request $request){
        $apis = new ApiHelper();
        $rules = [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'details' => 'required|string',
            'category_id' => 'required|integer',
            'city_id' => 'required|integer',
            'currency' => 'required|integer',
            'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $data['errors'] = $validator->getMessageBag()->toArray();
            $apis->createApiResponse(false,200,"",$data);
            return;
        }else {
            $user = $request->user();

            $name_array['ar'] = $request->name;
            $data['name'] = json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            $details_array['ar'] = $request->details;
            $data['details'] = json_encode($details_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            $address_array['ar'] = $request->address;
            $data['address'] = json_encode($address_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            $data['user_id'] = $user->id;
            $data['category_id'] = $request->category_id;
            $data['price'] = $request->price;
            $data['currency'] = $request->currency;
            $data['discount_price'] = 0;
            $data['city_id'] = $request->city_id;
            $data['is_deleted'] = 0;
            $data['type'] = 1;


            if ($request->main_image) {

                $png_url = "product-" . time() . ".png";
                $path = public_path() . '/uploads/ads/' . $png_url;
                Image::make(file_get_contents($request->main_image))->save($path);
                $data['main_image'] = $png_url;

            }

            $new_ad = Ad::create($data);


            if ($request->extra_images and is_array($request->extra_images)) {
                foreach ($request->extra_images as $extra) {
                    $png_url_extra = "product-" . time() . ".png";
                    $path = public_path() . '/uploads/ads/' . $png_url_extra;
                    Image::make(file_get_contents($extra))->save($path);
                    $extra_data['image'] = $png_url_extra;
                    $extra_data['ad_id'] = $new_ad->id;

                    AdImage::create($extra_data);
                }
            }


            $apis->createApiResponse(false, 200, "تم الإضافة بنجاح", "");
            return;
        }
    }

    public function update(Request  $request){
        $apis = new ApiHelper();
        $product = Ad::find($request->product_id);
        $user = $request->user();
        if($product and ($user->id == $product->user_id)){
            $rules = [
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'details' => 'required|string',
                'category_id' => 'required|integer',
                'city_id' => 'required|integer',
                'currency' => 'required|integer',
                'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $data['errors'] = $validator->getMessageBag()->toArray();
                $apis->createApiResponse(false,200,"","");
                return;
            }else {
                $user = $request->user();

                $name_array['ar'] = $request->name;
                $data['name'] = json_encode($name_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

                $details_array['ar'] = $request->details;
                $data['details'] = json_encode($details_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

                $address_array['ar'] = $request->address;
                $data['address'] = json_encode($address_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

                $data['user_id'] = $user->id;
                $data['category_id'] = $request->category_id;
                $data['price'] = $request->price;
                $data['currency'] = $request->currency;
                $data['discount_price'] = 0;
                $data['city_id'] = $request->city_id;
                $data['is_deleted'] = 0;
                $data['type'] = 1;

                if ($request->main_image) {

                    if ($product->main_image != '') {

                        Storage::disk('public_uploads')->delete('/ads/' . $product->main_image);

                    }//end of if

                    $png_url = "product-" . time() . ".png";
                    $path = public_path() . '/uploads/ads/' . $png_url;
                    Image::make(file_get_contents($request->main_image))->save($path);
                    $data['main_image'] = $png_url;

                }
                $product->update($data);
                $apis->createApiResponse(false, 200, "تم التعديل بنجاح", "");
                return;
            }
        }
        else{
            $apis->createApiResponse(true, 404, "NOT FOUND", "");
            return;
        }
    }

    public function add_extra(Request $request){
        $apis = new ApiHelper();
        $product = Ad::find($request->product_id);
        $user = $request->user();
        if($product and $user->id == $product->user_id){
            if ($request->extra_images and is_array($request->extra_images)) {
                foreach ($request->extra_images as $extra) {
                    $png_url_extra = "product-" . time() . ".png";
                    $path = public_path() . '/uploads/ads/' . $png_url_extra;
                    Image::make(file_get_contents($extra))->save($path);
                    $extra_data['image'] = $png_url_extra;
                    $extra_data['ad_id'] = $product->id;

                    AdImage::create($extra_data);
                }

                $apis->createApiResponse(false, 200, "تم الإضافة بنجاح", "");
                return;
            }
        }else{
            $apis->createApiResponse(true, 404, "NOT FOUND", "");
            return;
        }
    }

    public function delete_extra(Request $request){
        $apis = new ApiHelper();
        $extra = AdImage::find($request->extra_id);
        if($extra){
            if ($extra->image != '') {
                Storage::disk('public_uploads')->delete('/ads/' . $extra->image);
            }//end of if
            $extra->delete();
            $apis->createApiResponse(false, 200, "تم الحذف بنجاح", "");
            return;
        }

        $apis->createApiResponse(true, 404, "NOT FOUND", "");
        return;
    }


}
