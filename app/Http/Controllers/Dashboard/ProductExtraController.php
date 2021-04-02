<?php

namespace App\Http\Controllers\Dashboard;

use App\Color;
use App\ExtraImage;
use App\Flavor;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProductExtraController extends Controller
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
            'product_id' => 'required|integer',
            'color_id' => 'required|integer',
            'quantity' => 'integer',
            'image' => 'image'
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request)
    {
        $data['title'] = __('site.extras');
        $data['extras'] = ExtraImage::when($request->product_id, function ($q) use ($request) {

            return $q->where('product_id',$request->product_id);
        })->latest('id')->get();

        foreach ($data['extras'] as $e){
            $e->color = Color::find($e->color_id);
        }
        $data['pro'] = Product::find($request->product_id);
        $data['product_id'] = $request->product_id;

        $data['url'] = route(env('DASH_URL') . '.extras.index');

        return view('dashboard.extras.index', compact('data','request'));

    }

    public function create(Request $request)
    {
       if($request->product_id){
           $data['title'] = __('site.add_extras');
           $data['url'] = route(env('DASH_URL') . '.extras.store');
           $data['product_id'] = $request->product_id;
           $data['pro'] = Product::find($request->product_id);
           $data['colors'] = $data['pro']->var_type == 1 ? Color::where('type',1)->get() : Color::where('type',2)->orWhere('id',17)->get();
           return view('dashboard.extras.create', compact('data'));
       }
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
            $data['product_id'] = $request->product_id;
            $data['color_id'] = $request->color_id;
            $data['quantity'] = $request->quantity;
            if ($request->image) {

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/products/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }//end of if

            ExtraImage::create($data);
            return response()->json(array('success' => true), 200);
        }
    }

    public function edit($id)
    {
        $form_data = ExtraImage::find($id);
        $data['title'] = __('site.edit_extras');
        $data['product_id'] = $form_data->product_id;
        $data['pro'] = Product::find( $data['product_id'] );
        $data['colors'] = $data['pro']->var_type == 1 ? Color::where('type',1)->get() : Color::where('type',2)->orWhere('id',17)->get();
        $data['url'] = route(env('DASH_URL') . '.extras.update',$id);
        return view('dashboard.extras.edit', compact('data','form_data'));
    }

    public function update(Request $request,$id)
    {
        $extra = ExtraImage::find($id);
        $validator = $this->validate_page($request);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $data['color_id'] = $request->color_id;
            $data['quantity'] = $request->quantity;
            if ($request->image) {

                if ($extra->img != '') {

                    Storage::disk('public_uploads')->delete('/products/' . $extra->img);

                }//end of if

                Image::make($request->image)
                    ->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('uploads/products/' . $request->image->hashName()));

                $data['img'] = $request->image->hashName();

            }//end of if
            $extra->update($data);

            return response()->json(array('success' => true), 200);
        }
    }

    public function destroy($id)
    {
        $extra = ExtraImage::find($id);
        if ($extra->img != 'default.png') {

            Storage::disk('public_uploads')->delete('/products/' . $extra->img);

        }//end of if

        $extra->delete();
        return response()->json(array('success' => true), 200);

    }
}
