<?php

namespace App\Http\Controllers\Dashboard;

use App\Ad;
use App\Brand;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AdvertismentController extends Controller
{
    public function __construct()
    {
        //create read update delete
        $this->middleware(['permission:products-read'])->only('index', 'show');
        $this->middleware(['permission:products-create'])->only('create', 'store');
        $this->middleware(['permission:products-update'])->only('edit', 'update');
        $this->middleware(['permission:products-delete'])->only('destroy');
    }

    private function validate_page($request)
    {
        $rules = [
            'type' => 'required|integer',
            'image' => 'image'
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.ads');
        $data['ads'] = Ad::latest('id')->paginate(20);
        $data['url'] = route(env('DASH_URL') . '.ads.index');
        return view('dashboard.ads.index', compact('data'));
    }
    public function create(Request $request)
    {
        $data['title'] = __('site.add_ads');
        $data['brands'] = Brand::all();
        $data['url'] = route(env('DASH_URL') . '.ads.store');
        $data['ad_id'] = $request->id ? $request->id : 0;
        return view('dashboard.ads.create', compact('data'));
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
            $data['type'] = $request->type;
            $ad_id = 0;
            if($request->type == 1){
                $pro = Product::where('sku',$request->sku)->get()->first();
                $ad_id = $pro->id;
            }else if($request->type == 2){
                $ad_id = $request->brand_id;
            }
            $data['ad_id'] = $ad_id;
            if ($request->image) {

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/ads/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }//end of if


            Ad::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = Ad::find($id);
        $data['title'] = __('site.edit_ads');
        $data['ad_id'] = $form_data->ad_id;

        $data['url'] = route(env('DASH_URL') . '.ads.update',$form_data->id);
        return view('dashboard.ads.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $ad = Ad::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {

            if ($request->image) {

                if ($ad->img != '') {

                    Storage::disk('public_uploads')->delete('/ads/' . $ad->img);

                }//end of if

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/ads/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }//end of if
            $ad->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $ad = Ad::find($id);
        if ($ad->img != 'default.png') {

            Storage::disk('public_uploads')->delete('/ads/' . $ad->img);

        }//end of if

        $ad->delete();
        return response()->json(array('success' => true), 200);

    }
}
