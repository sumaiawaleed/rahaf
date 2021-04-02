<?php

namespace App\Http\Controllers\APi;

use App\Ad;
use App\AdImage;
use App\AdReviews;
use App\Category;
use App\City;
use App\Favorite;
use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\Store;
use App\User;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    private function get_owner($user_id)
    {
        $store = Store::where('user_id', $user_id)->first();
        if ($store) {
            return array('name' => $store->getTranslateName('ar'), 'id' => $store->id, "type" => "متجر");
        } else {
            $user = User::find($user_id);
            if ($user) {
                return array('name' => $user->name, 'id' => $user_id, "type" => "مستخدم");
            } else {
                return array('name' => "", 'id' => "", "type" => "");

            }
        }
    }

    private function get_category($category_id)
    {
        return Category::find($category_id);
    }

    private function get_city($city_id)
    {
        return City::find(1);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $result = array();
        $i = 0;
        $data['data'] = Ad::select('id', 'name', 'main_image', 'price', 'discount_price', 'category_id')
            ->
            when($request->search, function ($q) use ($request) {

                return $q->where('name','LIKE', '%' . $request->search . '%');

            })->when($request->category_id, function ($q) use ($request) {

                return $q->where('category_id', $request->category_id);

            })->when($request->city_id, function ($q) use ($request) {

                return $q->where('city_id', $request->city_id);

            })->when($request->user_id, function ($q) use ($request) {

                return $q->where('user_id', $request->user_id);

            })->where('type', 1)
            ->latest()->paginate(20);

        $data['data'] = $this->featch_products($data['data'],$user);

        unset($data["main_image_path"]);


        $apis = new ApiHelper();
        $apis->createApiResponse(false, 200, "", $data);
        return;
    }

    public function show($id)
    {
        $apis = new ApiHelper();
        $c = Ad::select('id','name','main_image','price','discount_price',
            'category_id','details','address')->where('id', $id)->where('is_deleted', 0)->first();
        if ($c) {
            $c->name = $c->getTranslateName('ar');
            $c->details = $c->getTranslateDetails('ar');
            $c->main_image_path = $c->image_path;

            $category = $this->get_category($c->category_id);
            $main_ca = Category::where('id',Category::find($category->id)->parent_id)->get()->first();
            $c->category_id = $category->id;
            $c->category_name = $category->getTranslateName('ar');
            $c->main_category_name = ($main_ca) ? $main_ca->getTranslateName('ar') : "";


            $owner = $this->get_owner($c->user_id);
            $c->owner_type = $owner['type'];
            $c->owner_id = $owner['id'];
            $c->owner_name = $owner['name'];
            $c->address = $c->getTranslateAddress('ar');

            $city = $this->get_city($c->city_id);
            $c->city_name = $city->getTranslateName('ar');
            $c->city_id = $city->id;

            $c->extra_images = '';


            $extra_images = AdImage::where('ad_id', $c->id);

            foreach ($extra_images as $ex) {
                $c->extra_images .=  $ex->image_path.',';
            }

            $data = $c;
            $apis->createApiResponse(false, 200, "", $data);
            return;
        } else {
            $apis->createApiResponse(true, 200, "لا توجد بيانات", "");
        }
    }

    public function featch_products($data,$user = null)
    {
        foreach ($data as $c) {
            $c->name = $c->getTranslateName('ar');
            $c->details = $c->getTranslateDetails('ar');
            $c->main_image_path = $c->image_path;

            $category = $this->get_category($c->category_id);
            $main_ca = Category::where('id',Category::find($category->id)->parent_id)->get()->first();
            $c->category_id = $category->id;
            $c->main_category_name = ($main_ca) ? $main_ca->getTranslateName('ar') : "";
            $c->category_name = $category->getTranslateName('ar');

            $owner = $this->get_owner($c->user_id);
            $c->owner_type = $owner['type'];
            $c->owner_id = $owner['id'];
            $c->owner_name = $owner['name'];
            $c->address = $c->getTranslateAddress('ar');

            $city = $this->get_city($c->city_id);
            $c->city_name = $city->getTranslateName('ar');
            $c->city_id = $city->id;

            $c->is_favorite = 0;

            if($user){
                $fav  = Favorite::where('ad_id',$c->id)
                    ->where('user_id',$user->id)->get();
                $c->is_favorite = ($fav->count() > 0) ? 1 : 0;
            }

            $c->extra_images = "";

            $extra_images = AdImage::where('ad_id', $c->id)->get();

            foreach ($extra_images as $ex) {
                $c->extra_images .= "," . $ex->image_path;
            }
        }


        return $data;
    }

    public function reviews($id){
        $apis = new ApiHelper();
        $data['total'] = AdReviews::where('ad_id',$id)->sum('stars');
        $data['reviews'] = AdReviews::where('ad_id',$id)->latest()->paginate(20);

        foreach ($data['reviews'] as $review){
            $user = User::find($review->user_id);
            $review->user_name = $user->name;
            $review->user_image = $user->image_path;
            unset($review->updated_at);
            unset($review->is_deleted);
        }


        $apis->createApiResponse(false, 200, "", $data);
        return;
    }
}
