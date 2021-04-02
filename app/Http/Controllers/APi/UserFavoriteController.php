<?php

namespace App\Http\Controllers\APi;

use App\Ad;
use App\Favorite;
use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    public function index(Request $request){
        $user = $request->user()->id;

        $products = Ad::when($request->search, function ($q) use ($request) {

            return $q->where('name', 'LIKE', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->join('favorites','favorites.ad_id','=','ads.id')
            ->where('favorites.user_id',$user->id)
            ->where('is_deleted', 0)
            ->latest('favorites.created_at')
            ->paginate(20);

        $p = new ProductsController();
        $data['products'] = $p->featch_products($products);

        $apis = new ApiHelper();
        $apis->createApiResponse(true,200,"",$data);
        return;
    }

    public function store(Request $request){
        $user = $request->user()->id;
        $apis = new ApiHelper();
        $product = Ad::find($request->product_id);
        if($product and $product->user_id != $user->id){
            $data['user_id'] = $user->id;
            $data['ad_id'] = $request->product_id;

            $fav = Favorite::where($data)->first();
            if(!$fav){
                Favorite::create($data);
            }
            $apis->createApiResponse(false, 200, "تم الإضافة بنجاح", "");
            return;
        }else{
            $apis->createApiResponse(true, 404, "NOT FOUND", "");
            return;
        }
    }
    public function destory(Request $request){
        $apis = new ApiHelper();
        $user = $request->user();
        $fav = Favorite::where('user_id',$user->id)
            ->where('ad_id',$request->product_id)
            ->first();
        if($fav){
            $fav->delete();
        }

        $apis->createApiResponse(false, 200, "تم الحذف بنجاح", "");
        return;
    }
}
