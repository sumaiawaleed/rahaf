<?php

namespace App\Http\Controllers\APi;

use App\AdReviews;
use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserReviewController extends Controller
{
    public function store(Request $request)
    {
        $apis = new ApiHelper();
        $user = $request->user();
        $rules = [
            'id' => [
                'required',
                Rule::exists('ads'),
            ],
            'review' => 'required|string|max:500',
            'stars' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $data['errors'] = $validator->getMessageBag()->toArray();
            $apis->createApiResponse(true, 200, "", "");
            return;
        } else {
            $data['ad_id'] = $request->id;
            $data['user_id'] = $user->id;
            $data['review'] = $request->review;
            $data['stars'] = $request->stars;
            $data['is_deleted'] = 0;

            AdReviews::create($data);

            $apis->createApiResponse(false, 200, "تم الإضافة بنجاح", "");
            return;
        }


    }

    public function update(Request $request)
    {
        $apis = new ApiHelper();
        $user = $request->user();
        $rules = [
            'id' => [
                'required',
                Rule::exists('ads_reviews'),
            ],
            'review' => 'required|string|max:500',
            'stars' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $data['errors'] = $validator->getMessageBag()->toArray();
            $apis->createApiResponse(true, 200, "", "");
            return;
        } else {
           $review = AdReviews::find($request->id);
            $data['review'] = $request->review;
            $data['stars'] = $request->stars;
            $data['is_deleted'] = 0;

            $review->update($data);

            $apis->createApiResponse(false, 200, "تم التعديل بنجاح", "");
            return;
        }
    }

    public function destroy(Request $request){
        $apis = new ApiHelper();
        $user = $request->user();
        $rules = [
            'id' => [
                'required',
                Rule::exists('ads_reviews'),
            ],
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $data['errors'] = $validator->getMessageBag()->toArray();
            $apis->createApiResponse(true, 200, "", "");
            return;
        } else {
            $review = AdReviews::find($request->id);
            $data['is_deleted'] = 1;

            $review->update($data);

            $apis->createApiResponse(false, 200, "تم الحذف بنجاح", "");
            return;
        }
    }
}
