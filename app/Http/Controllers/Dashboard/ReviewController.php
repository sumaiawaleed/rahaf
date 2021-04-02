<?php

namespace App\Http\Controllers\Dashboard;

use App\Ad;
use App\AdReviews;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:rates-read'])->only('index', 'show');
        $this->middleware(['permission:rates-create'])->only('create', 'store');
        $this->middleware(['permission:rates-update'])->only('edit', 'update');
        $this->middleware(['permission:rates-delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        $data['reviews'] = AdReviews::when($request->ad_id, function ($q) use ($request) {

            return $q->where('ad_id', $request->ad_id );

        })->when($request->user_id, function ($q) use ($request) {

            return $q->where('user_id', $request->user_id);

        })
            ->where('is_deleted', 0)
            ->latest()
            ->paginate(20);

        foreach ($data['reviews'] as $rate){
            $rate->product = Ad::find($rate->ad_id);
            $rate->user = User::find($rate->user_id);
        }


        if ($request->ajax()) {
            return view('dashboard.reviews._pagination_data', compact('data'))->render();
        } else {
            $data['title'] = __('site.reviews');
            return view('dashboard.reviews.index', compact('data'));
        }
    }

    public function archive(Request $request){
        $data['reviews'] = AdReviews::when($request->ad_id, function ($q) use ($request) {

            return $q->where('ad_id', $request->ad_id );

        })->when($request->user_id, function ($q) use ($request) {

            return $q->where('user_id', $request->user_id);

        })
            ->where('is_deleted', 1)
            ->latest()
            ->paginate(20);

        foreach ($data['reviews'] as $rate){
            $rate->product = Ad::find($rate->ad_id);
            $rate->user = User::find($rate->user_id);
        }


        if ($request->ajax()) {
            return view('dashboard.reviews._pagination_data', compact('data'))->render();
        } else {
            $data['title'] = __('site.reviews');
            return view('dashboard.reviews.archive', compact('data'));
        }
    }

    public function edit($id){
        $review = AdReviews::find($id);
        $data['title'] = __('site.edit_review');
        $data['page_msg'] = __('site.data_updated_successfully');

        return view('dashboard.reviews.edit', compact('data','review'));

    }

    public function update(Request $request, $id)
    {
        $review = AdReviews::find($id);
        $rules = [
            'comment' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {


            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        }

        $request_data['review'] = $request->comment;
        $review->update($request_data);

        return response()->json(array('success' => true), 200);
    }

    public function destroy($id)
    {
        $rate = AdReviews::find($id);
        $data['is_deleted'] = 1;

        $f = $rate->update($data);
        $w  = new WelcomeController();
        $w->add_log('archive','reviews');
        $f = $rate->update($data);
        return response()->json(array('success' => true), 200);
    }

    public function restore(Request $request){
        $rate = AdReviews::find($request->rate_id);
        $data['is_deleted'] = 0;
        $w  = new WelcomeController();
        $w->add_log('restore','reviews');
        $f = $rate->update($data);
        return response()->json(array('success' => false), 200);
    }
}
