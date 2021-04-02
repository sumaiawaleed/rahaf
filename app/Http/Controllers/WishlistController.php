<?php

namespace App\Http\Controllers;

use App\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function remove(Request $request){
        $fav = Favourite::where('user_id',Auth::user()->id)->where('product_id',$request->id)->first();
        if($fav){
            $fav->delete();
            $data['success'] = TRUE;
            $data['message'] = __('site.remove_form_wishlist_success');
            return json_encode($data);
        }else{
            $data['success'] = FALSE;
            $data['message'] = __('site.cannt_remove_form_wishlist');
            return json_encode($data);
        }
    }
    public function add(Request $request){
        $fav = Favourite::where('user_id',Auth::guard('cutomers')->user()->id)->where('product_id',$request->id)->first();
        if($fav){
            $data['success'] = FALSE;
            $data['message'] = __('site.already_in_wishlist');
            return json_encode($data);
        }else{
            $request_data['user_id'] = Auth::guard('cutomers')->user()->id;
            $request_data['product_id'] = $request->id;
            Favourite::create($request_data);
            $data['success'] = TRUE;
            $data['message'] = __('site.add_to_wishlist_successfully');
            return json_encode($data);
        }
    }
}
