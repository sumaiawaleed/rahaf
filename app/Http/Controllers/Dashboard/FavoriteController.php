<?php

namespace App\Http\Controllers\Dashboard;

use App\Ad;
use App\Favorite;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FavoriteController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:favorites-read'])->only('index', 'show');
        $this->middleware(['permission:favorites-create'])->only('create', 'store');
        $this->middleware(['permission:favorites-update'])->only('edit', 'update');
        $this->middleware(['permission:favorites-delete'])->only('destroy');
    }
    public function index(Request $request)
    {
        $data['favorites'] = Favorite::when($request->ad_id, function ($q) use ($request) {

            return $q->where('ad_id', $request->ad_id );

        })->when($request->user_id, function ($q) use ($request) {

            return $q->where('user_id', $request->user_id);

        })
            ->where('is_deleted', 0)
            ->latest()
            ->paginate(20);

        foreach ($data['favorites'] as $fav){
            $fav->product = Ad::find($fav->ad_id);
            $fav->user = User::find($fav->user_id);
        }


        if ($request->ajax()) {
            return view('dashboard.favorites._pagination_data', compact('data'))->render();
        } else {
            $data['title'] = __('site.favorites');
            return view('dashboard.favorites.index', compact('data'));
        }
    }

    public function archive(Request $request){
        $data['favorites'] = Favorite::when($request->ad_id, function ($q) use ($request) {

            return $q->where('ad_id', $request->ad_id );

        })->when($request->user_id, function ($q) use ($request) {

            return $q->where('user_id', $request->user_id);

        })
            ->where('is_deleted', 1)
            ->latest()
            ->paginate(20);

        foreach ($data['favorites'] as $fav){
            $fav->product = Ad::find($fav->ad_id);
            $fav->user = User::find($fav->user_id);
        }


        if ($request->ajax()) {
            return view('dashboard.favorites._pagination_data', compact('data'))->render();
        } else {
            $data['title'] = __('site.favorites');
            return view('dashboard.favorites.archive', compact('data'));
        }
    }

    public function destroy($id)
    {
        $fav = Favorite::find($id);
        $data['is_deleted'] = 1;

        $f = $fav->update($data);

        return response()->json(array('success' => true), 200);
    }

    public function restore(Request $request){
        $fav = Favorite::find($request->favorite_id);
        $data['is_deleted'] = 0;
        $w  = new WelcomeController();
        $w->add_log('restore','stores');
        $f = $fav->update($data);
        return response()->json(array('success' => false), 200);
    }
}
